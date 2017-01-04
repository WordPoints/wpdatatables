#!/usr/bin/env bash

set -e
shopt -s expand_aliases

# Sets up custom configuration.
function wordpoints-dev-lib-config() {

	# Ignore some strings that are expected.
	CODESNIFF_IGNORED_STRINGS=(\
		"${CODESNIFF_IGNORED_STRINGS[@]}" \
		# Doesn't support HTTPS.
		-e wpdatatables.com \
	)

	alias setup-phpunit="\setup-phpunit; unzip wpdatatables.zip -d /tmp/wordpress/src/wp-content/plugins/"
}

set +e

# EOF
