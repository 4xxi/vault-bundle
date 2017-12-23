#!/usr/bin/env bash
set -ex

nohup vault server -dev > vault.log 2>&1&
sleep 2
cat vault.out | sed  -n "s/^Root Token: \(.*\)$/VAULT_TOKEN='\1'/p" > .env