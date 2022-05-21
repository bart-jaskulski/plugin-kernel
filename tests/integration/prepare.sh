#!/bin/bash

if [ ! -d $DEPENDENT_PLUGINS_DIR/flexible-checkout-fields ]
then
    echo "FCF"
    /tmp/clone.sh git@gitlab.com:wpdesk/flexible-checkout-fields.git $DEPENDENT_PLUGINS_DIR/flexible-checkout-fields master
    cd $DEPENDENT_PLUGINS_DIR/flexible-checkout-fields/
    composer install
    cd /tmp
fi

echo
