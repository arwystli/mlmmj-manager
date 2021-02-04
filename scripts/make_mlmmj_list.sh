#!/bin/sh

# @author Bob Hutchinson <arwystli@gmail.com>
# @copyright GNU GPL

# http://mlmmj.org/releases/mlmmj-1.3.0.tar.gz
# or apt install mlmmj

# these may need editing
cmddir="/usr/local/bin"

sharedir="/usr/local/share/mlmmj"
if [ ! -d "$sharedir" ]; then
  echo "$sharedir does not exist, mlmmj not installed."
  exit 1
fi

spooldir="/var/spool/mlmmj"
if [ ! -d "$spooldir" ]; then
  echo "$spooldir does not exist, mlmmj not installed."
  exit 2
fi

postfixdir="/etc/postfix"
if [ ! -d "$postfixdir" ]; then
  echo "$postfixdir does not exist, postfix not installed."
  exit 3
fi

postfixfilesdir="$postfixdir/mlmmj"
if [ ! -d "$postfixfilesdir" ]; then
  mkdir -p $postfixfilesdir
fi
transport_txt="$postfixfilesdir/transport"
virtual_txt="$postfixfilesdir/virtual"
virtual_tpl="__LISTNAME__@__DOMAIN__  __DOMAIN__--__LISTNAME__@localhost.mlmmj"
transport_tpl="__DOMAIN__--__LISTNAME__@localhost.mlmmj mlmmj:__DOMAIN__/__LISTNAME__"

# cli params
if [ -z "$2" ]; then
  echo "need params: list name and owner email, eg mylist@example.com owner@example.com"
  exit 4
fi

here="/root"
listn="$1"
owner="$2"
l=`echo $listn | cut -d'@' -f1`
d=`echo $listn | cut -d'@' -f2`

# ownership
u="mlmmj"
g="mlmmj"
w="www-data"

# make the dirs in the form of spooldir/domain/listname
# but check it exists first, if it does bail out
if [ -d "$spooldir/$d/$l" ]; then
  echo "$spooldir/$d/$l already exists, bailing out"
  exit 5
fi

listdir="$spooldir/$d/$l"

# OK go ahead and create
mkdir -p $listdir

subdirs="archive bounce control digesters.d incoming moderation nomailsubs.d queue queue/discarded requeue subconf subscribers.d text unsubconf"

for sdir in $subdirs; do
  mkdir -p "$listdir/$sdir"
done

touch "$listdir/index"

echo "$owner" > "$listdir/control/owner"
echo "$listn" > "$listdir/control/listaddress"
echo "Mailing-List: contact $l+help@$d; run by mlmmj" > "$listdir/control/customheaders"
echo "Precedence: bulk" >> "$listdir/control/customheaders"
echo "List-Subscribe: <mailto:$l+subscribe@$d?subject=subscribe>" >> "$listdir/control/customheaders"
echo "List-Unsubscribe: <mailto:$l+unsubscribe@$d?subject=unsubscribe>" >> "$listdir/control/customheaders"
echo "List-Help: <mailto:$l+help@$d?subject=help>" >> "$listdir/control/customheaders"
echo "List-Id: Mailing list for $listn" >> "$listdir/control/customheaders"
echo "-- " > "$listdir/control/footer"
echo "------------" >> "$listdir/control/footer"
echo "To get help on how to use this list just send an empty message to $l+help@$d" >> "$listdir/control/footer"


(
  cd "$sharedir/text.skel"
  echo
  echo "For the list texts you can choose between the following languages or"
  echo "give a absolute path to a directory containing the texts."
  echo
  echo "Available languages:"
  ls

  textpathdef=en
  echo -n "The path to texts for the list? [$textpathdef] : "
  read textpathin
  if [ -z "$textpathin" ] ; then
    textpath="$textpathdef"
  else
    textpath="$textpathin"
  fi
  if [ ! -d "$textpath" ]; then
    echo
    echo "**NOTE** Could not copy the texts for the list"
    echo "Please manually copy the files from the listtexts/ directory"
    echo "in the source distribution of mlmmj."
    sleep 2
  else
    cp $textpath/* $listdir/text/
  fi
)

# set perms
. ./set_mlmmj_perms.sh $listn

mlmmjreceive=`which mlmmj-receive 2>/dev/null`
if [ -z "$mlmmjreceive" ]; then
  mlmmjreceive="/path/to/mlmmj-receive"
fi

mlmmjmaintd=`which mlmmj-maintd 2>/dev/null`
if [ -z "$mlmmjmaintd" ]; then
  mlmmjmaintd="/path/to/mlmmj-maintd"
fi

cronentry="0 */2 * * * \"$mlmmjmaintd -F -L $listdir/\""

echo "$transport_tpl" | sed -e "s/__DOMAIN__/$d/g" -e "s/__LISTNAME__/$l/g" >> $transport_txt
echo "$virtual_tpl" | sed -e "s/__DOMAIN__/$d/g" -e "s/__LISTNAME__/$l/g" >> $virtual_txt

postmap $virtual_txt
postmap $transport_txt
postfix reload

echo
echo "If you're not starting mlmmj-maintd in daemon mode,"
echo "don't forget to add this to your crontab:"
echo "$cronentry"
