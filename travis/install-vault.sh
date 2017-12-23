#!/usr/bin/env bash
set -ex

VAULT_VERSION=${VAULT_VERSION:-0.9.1}
OS="linux"
if [[ "$TRAVIS_OS_NAME" == "osx" ]]; then
    OS="darwin"
fi

DOWNLOAD_URL=https://releases.hashicorp.com/vault/${VAULT_VERSION}/vault_${VAULT_VERSION}_${OS}_amd64.zip

wget -q -O /tmp/vault.zip ${DOWNLOAD_URL}
unzip -d /tmp /tmp/vault.zip
mv /tmp/vault /usr/local/bin/vault
chmod +x /usr/local/bin/vault