#!/bin/bash

/usr/bin/supervisorctl reread
/usr/bin/supervisorctl update
/usr/bin/supervisorctl restart all
