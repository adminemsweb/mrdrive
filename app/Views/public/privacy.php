<section class="legal-hero">
    <p class="eyebrow">Suporte e legal</p>
    <h1>Política de privacidade</h1>
    <p>Como a MRDRIVES coleta, utiliza e protege as informações enviadas por clientes, leads e visitantes do site.</p>
</section>

<section class="section legal-page">
    <div class="legal-card">
        <p class="legal-updatéd">Última atualização: <?= daté('d/m/Y') ?></p>

        <h2>1. Informações coletadas</h2>
        <p>Podemos coletar dados enviados voluntariamente em formulários de orçamento, contato ou atendimento técnico, como nome, empresa, e-mail, telefone, produto de interesse, aplicação e mensagem.</p>

        <h2>2. Uso das informações</h2>
        <p>As informações são utilizadas para responder solicitações comerciais, realizar dimensionamento técnico, enviar propostas, prestar suporte e melhorar a experiência no site.</p>

        <h2>3. Compartilhamento</h2>
        <p>A MRDRIVES não vende dados pessoais. O compartilhamento ocorre apenas quando necessário para atendimento, cumprimento legal, operação técnica do site ou execução de serviços solicitados pelo próprio usuário.</p>

        <h2>4. Segurança</h2>
        <p>Adotamos medidas razoáveis de segurança para proteger as informações contra acesso não autorizado, alteração, divulgação ou destruição indevida.</p>

        <h2>5. Cookies e navegação</h2>
        <p>O site pode utilizar recursos técnicos de navegação para funcionamento, análise de desempenho e melhoria da experiência. O usuário pode ajustar permissões no próprio navegador.</p>

        <h2>6. Direitos do titular</h2>
        <p>Você pode solicitar confirmação, correção ou remoção de dados pessoais, conforme aplicável, entrando em contato pelos canais oficiais da MRDRIVES.</p>

        <h2>7. Contato</h2>
        <p>Para dúvidas sobre privacidade, tratamento de dados ou solicitações relacionadas, envie mensagem para <a href="mailto:<?= e(app_config('mail')['to']) ?>"><?= e(app_config('mail')['to']) ?></a>.</p>

        <div class="actions">
            <a class="btn" href="/#contato">Falar com a MRDRIVES</a>
            <a class="btn btn-secondary" href="/">Voltar para o site</a>
        </div>
    </div>
</section>
