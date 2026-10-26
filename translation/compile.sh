#!/bin/bash
# EasyI18n is licensed under the Apache License 2.0 license
# https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE

echo "Compiling: da_DK"
msgfmt -v da_DK/LC_MESSAGES/messages.po -o da_DK/LC_MESSAGES/messages.mo
echo "Compiling: en_US"
msgfmt -v en_US/LC_MESSAGES/messages.po -o en_US/LC_MESSAGES/messages.mo
