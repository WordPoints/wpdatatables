#!/usr/bin/env bash

set -e
shopt -s expand_aliases

# Sets up custom configuration.
function wordpoints-dev-lib-config() {
	alias setup-phpunit="\setup-phpunit; unzip wpdatatables.zip -d /tmp/wordpress/src/wp-content/plugins/"
}

set +e

# EOF
