#!/bin/bash

# Make sure we have enough parameters
if [ $#  -lt 2 ];
then
    echo "Not enough parameters"
    exit 1
fi

# Shorthand for bolding terminal text
bold=`tput bold`
normal=`tput sgr0`

# Set up the actual variables for the script
filename="expectations/$1.php"
index=$2
all_lines=""

if [ ! -f "$filename" ];
then
    echo "Creating $filename"
    echo -e "<?php\n\$expected = [];\n\nreturn \$expected;" >> $filename
fi

# An optional third argument is for a comment to be displayed 
comment=""
if [ "$3" != "" ];
then
    comment="\\/\\/ $3\n"
fi

echo -e "Enter in the lines of your expectation"
read line
while [ "$line" != "" ]; do
    all_lines="$all_lines\n$line"
    read line
done

return_line="return \$expected;"
new="$comment\$expected['$index'] = <<<CODE$all_lines\nCODE;"
sed -i "s/$return_line/$new\n\n$return_line/" "$filename"

echo -e "${bold}$new${normal} \nhas been written to ${bold}$filename${normal}"


