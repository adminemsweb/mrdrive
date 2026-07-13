# Deploy pelo GitHub

O repositório possui o workflow manual **Deploy MRDRIVES** em `.github/workflows/deploy.yml`.

Antes de rodar pela primeira vez, cadastre estes secrets no GitHub em:
`Settings > Secrets and variables > Actions > New repository secret`

- `VPS_HOST`: IP da VPS, exemplo `89.116.74.235`
- `VPS_USER`: usuário SSH, exemplo `root`
- `VPS_PORT`: porta SSH, exemplo `22`
- `VPS_SSH_KEY`: chave privada SSH com acesso à VPS

Para publicar:

1. Faça push das alterações para a branch `main`.
2. Abra `Actions` no GitHub.
3. Clique em `Deploy MRDRIVES`.
4. Clique em `Run workflow`.

O deploy atualiza apenas `/root/mrdrives`, `/var/www/mrdrives` e o serviço Docker `mrdrives_app`.
Ele não altera Realize, Samwha ou outros sites da VPS.
