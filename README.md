# MRDRIVES / MRD-320 Series

Sistema PHP 8+ para landing page industrial com catálogo dinâmico e painel administrativo protegido.

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

### Frontend moderno

O storefront utiliza Vite, Alpine.js, Swiper e Lucide. Depois de alterar arquivos em `resources/`, execute:

```powershell
npm install
npm run build
```

O build gera assets versionados em `public/build` e um manifest consumido automaticamente pelo PHP. O Docker executa `npm ci` e recompila o frontend durante a criação da imagem de produção.

Nesse modo, o site público abre em `http://127.0.0.1:8032`. A entrada administrativa exige a chave privada definida em `ADMIN_ENTRY_KEY`.
Use `.\stop-mrdrives.ps1` para parar apenas o servidor deste projeto.

## Acesso inicial

- Configure uma chave longa e aleatória em `ADMIN_ENTRY_KEY`.
- A entrada privada usa `/admin/index.php?access=SUA_CHAVE` e redireciona imediatamente para uma URL limpa.
- Sem a chave, as rotas administrativas respondem como página inexistente.
- Crie ou altere o usuário administrativo diretamente no ambiente de implantação; não documente senhas no repositório.
- A conta proprietária pode criar acessos individuais em **Equipe**. Contas administrativas nunca devem ser compartilhadas.
- Em bancos existentes, aplique `database/update_admin_users.sql` antes de liberar a gestão da equipe.

## Produtos, imagens e PDFs

### Catálogo Samwha DSP

O menu **Produtos Samwha DSP** abre `/samwha-dsp`. O backend consulta a API pública `https://samwha.com.br/api/products`, sem credenciais, e os detalhes por slug. Categorias são extraídas dos produtos para os filtros. Preços ficam sob consulta e a disponibilidade segue `stock_status`.

As respostas são armazenadas em `storage/samwha`, com atualização sob demanda a cada cinco minutos. Falhas HTTP ou respostas inválidas preservam a última resposta válida e exibem um aviso. Sem cache, aparece uma mensagem de indisponibilidade. Um detalhe com HTTP 404 deixa de ser exibido. O conteúdo HTML externo é exibido como texto; imagens e manuais relativos são resolvidos contra o domínio Samwha.

O usuário do PHP precisa de permissão de escrita em `storage/samwha` (configurada na imagem Docker). Para preservar o cache entre recriações do container, monte um volume nessa pasta. Verificação do contrato e das falhas: `php scripts/test-samwha.php`.

Para testar com a API local Samwha ativa, configure `SAMWHA_API_BASE=http://127.0.0.1:8010` no `.env`. O cache é separado por base; em produção use `https://samwha.com.br`.

No painel, acesse **Produtos** para criar, editar, ativar/desativar e ordenar itens do catálogo. Campos disponíveis:

- Nome, código/modelo, categoria
- Descrições curta e completa
- Potência, tensão, aplicações e especificações
- Imagem principal
- Galeria de imagens
- Manual PDF
- Status ativo/inativo e destaque
- Marcadores de vitrine: oferta, mais vendido e lançamento
- SKU, preço de venda e preço anterior
- Controle opcional de estoque e prazo de envio

Uploads aceitos:

- Imagens: JPG, PNG, WEBP
- Documentos: PDF
- Limite padrão: 8 MB
- Destinos: `public/uploads/products` e `public/uploads/documents`

## Documentos gerais

Use **Documentos** para cadastrar catálogo geral, manuais ou fichas técnicas em PDF. O primeiro documento ativo aparece como download do catálogo geral na landing page.

## Solicitações de orçamento

O formulário público salva as solicitações em `quote_requests`. No admin é possível visualizar, marcar como lida/não lida e excluir.

## Loja e carrinho

O catálogo público em `/catalogo` possui busca, filtros, ordenação e carrinho persistente no navegador. Produtos sem preço publicado entram normalmente no carrinho como **sob consulta**. A finalização em `/checkout` reúne dados do cliente e envia o resumo estruturado pelo WhatsApp para validação comercial.

Em bancos já existentes, execute `database/update_ecommerce.sql` antes de cadastrar preços e estoque. O script de deploy da VPS aplica essa atualização automaticamente.

Para separar nome e sobrenome nas contas de clientes existentes, aplique `database/update_customer_names.sql`.

## Integração Santander

A configuração sensível foi reservada no `.env.example` e permanece desativada por padrão. A etapa atual não cria cobranças: o checkout é assistido pelo WhatsApp. A ativação deve ser feita somente após definir o produto contratado no Santander (por exemplo, Pix ou boleto), obter credenciais de homologação, configurar certificado/chave no servidor e validar webhooks. Credenciais bancárias nunca devem ser enviadas ao navegador ou versionadas no Git.

## Identificação legal da loja

Antes de publicar o checkout, preencha no ambiente de produção `COMPANY_LEGAL_NAME`, `COMPANY_CNPJ`, `COMPANY_ADDRESS` e `COMPANY_SUPPORT_EMAIL`. Esses dados alimentam as páginas de termos, entrega, trocas, garantia, pagamento, privacidade e cookies. Os textos são uma base operacional e devem ser revisados com o responsável jurídico e fiscal da empresa.

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
