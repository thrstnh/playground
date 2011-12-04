#!/bin/zsh

REPO_PATH="/var/svn/repos/"
BACKUP_DIR=`date +svn_backup-%Y-%m-%d--%k%M%S`
BACKUP_PATH="/root/backups/$BACKUP_DIR"
BACKUPS="/root/backups/svn/"

cd $REPO_PATH

for d in `ls $REPO_PATH`
do
    mkdir $BACKUP_PATH -p
    svnadmin dump $REPO_PATH/$d > $BACKUP_PATH/$d.dump
done


cd $BACKUP_PATH
cd ..

print "packing $BACKUP_DIR.tar.bz2..."
tar cjf $BACKUP_DIR.tar.bz2 $BACKUP_DIR
print "done."

print "moving to /root/backups/svn/$BACKUP_DIR.tar.bz2"
mv $BACKUP_DIR.tar.bz2 svn
print "done."

print "removing $BACKUP_PATH"
rm -rf $BACKUP_DIR
print "done."

print "$BACKUP_PATH.tar.bz2 saved."
print "have a nice day..."

