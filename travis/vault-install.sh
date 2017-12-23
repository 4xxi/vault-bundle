#!/usr/bin/env bash
set -ex

VAULT_VERSION=${VAULT_VERSION:-0.9.1}
OS="linux"
if [[ "$TRAVIS_OS_NAME" == "osx" ]]; then
    OS="darwin"
fi

DOWNLOAD_URL=https://releases.hashicorp.com/vault/${VAULT_VERSION}/vault_${VAULT_VERSION}_${OS}_amd64.zip

wget ${DOWNLOAD_URL}
unzip vault_${VAULT_VERSION}_${OS}_amd64.zip
chmod +x vault