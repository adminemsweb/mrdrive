# MRDRIVES / MRD-320 Series

Sistema PHP 8+ para landing page industrial com catálogo dinâmico e painel administrativo em `/admin`.

## Instalação

1. Copie `.env.example` para `.env` e ajuste as credenciais do MySQL.
2. Crie o banco informado em `DB_DATABASE`.
3. Importe `database/schema.sql`.
4. Importe `database/seed.sql`.
5. Aponte o servidor web para a pasta raiz do projeto. Em Apache, o `.htaccess` redireciona o tráfego público para `public/index.php`.

Para testar localmente:

```powershell
.\start-mrdrives.ps1
```

Nesse modo, o site público abre em `http://127.0.0.1:8032` e o painel em `http://127.0.0.1:8032/admin`.
Use `.\stop-mrdrives.ps1` para parar apenas o servidor deste projeto.

## Acesso inicial

- URL: `/admin`
- E-mail: `admin@mrdrives.com.br`
- Senha inicial: `Mrd@320#2026`

Altere a senha após o primeiro acesso. A senha no banco usa `password_hash`.

## Produtos, imagens e PDFs

No painel, acesse **Produtos** para criar, editar, ativar/desativar e ordenar itens do catálogo. Campos disponíveis:

- Nome, código/modelo, categoria
- Descrições curta e completa
- Potência, tensão, aplicações e especificações
- Imagem principal
- Galeria de imagens
- Manual PDF
- Status ativo/inativo e destaque

Uploads aceitos:

- Imagens: JPG, PNG, WEBP
- Documentos: PDF
- Limite padrão: 8 MB
- Destinos: `public/uploads/products` e `public/uploads/documents`

## Documentos gerais

Use **Documentos** para cadastrar catálogo geral, manuais ou fichas técnicas em PDF. O primeiro documento ativo aparece como download do catálogo geral na landing page.

## Solicitações de orçamento

O formulário público salva as solicitações em `quote_requests`. No admin é possível visualizar, marcar como lida/não lida e excluir.

## E-mail do formulário

O envio usa a função `mail()` do PHP. Configure no `.env`:

```env
MAIL_TO=comercial@mrdrives.com.br
MAIL_FROM=site@mrdrives.com.br
```

Em hospedagens sem `mail()` configurado, substitua o método `sendMail()` em `app/Controllers/PublicController.php` por SMTP autenticado, como PHPMailer.

## Segurança aplicada

- PDO com prepared statements
- Autenticação de admin com sessão PHP
- Senha criptografada com `password_hash`
- Proteção CSRF nos formulários sensíveis
- Validação de extensão, MIME e tamanho em uploads
- Rotas administrativas protegidas
- Erros ocultos em produção por padrão
