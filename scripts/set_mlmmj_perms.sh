#!/bin/sh

if [ -z "$1" ]; then
  echo "need params: list name, eg mylist@example.com"
  exit 1
fi

listn="$1"
l=`echo $listn | cut -d'@' -f1`
d=`echo $listn | cut -d'@' -f2`

# ownership
u="mlmmj"
g="mlmmj"
w="www-data"

if [ ! "$spooldir" ]; then
  spooldir="/var/spool/mlmmj"
fi

if [ -d "$spooldir/$d/$l" ]; then

  # set perms
  chown -R $u:$g "$spooldir/$d"
  # allow web access for mlmmj-admin, set setgid so that created files have mlmmj as group
  chown -R $w:$g "$spooldir/$d/$l/subscribers.d"
  chmod 775 "$spooldir/$d/$l/subscribers.d"
  chmod g+s "$spooldir/$d/$l/subscribers.d"

  chown -R $w:$g "$spooldir/$d/$l/control"
  chmod 775 "$spooldir/$d/$l/control"
  chmod g+s "$spooldir/$d/$l/control"

  chown -R $w:$g "$spooldir/$d/$l/queue"
  chmod 775 "$spooldir/$d/$l/queue"
  chmod g+s "$spooldir/$d/$l/queue"

  chown -R $w:$g "$spooldir/$d/$l/queue/discarded"
  chmod 775 "$spooldir/$d/$l/queue/discarded"
  chmod g+s "$spooldir/$d/$l/queue/discarded"

else
  echo "$spooldir/$d/$l does not exist"
  exit 2
fi
