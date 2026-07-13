<?php use App\Core\Csrf; ?>
<section class="section ticket-page" id="ticket">
    <div class="ticket-copy">
        <p class="eyebrow">Ticket técnico</p>
        <h1>Envie os dados da aplicação direto para o WhatsApp.</h1>
        <p>Preencha as informações principais. Ao enviar, a mensagem ja abre pronta no WhatsApp da MRDRIVES.</p>
    </div>

    <form class="quote-form ticket-form" action="/ticket" method="post" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <input type="hidden" name="ticket_type" value="Solicitação técnica">
        <div class="ticket-form-grid">
            <label>Nome<input name="name" required></label>
            <label>Empresa<input name="company"></label>
            <label>E-mail<input type="email" name="email"></label>
            <label>WhatsApp<input name="phone" required placeholder="+55 11 99999-9999"></label>
            <label>Produto
                <select name="product_interest">
                    <option>MRD600</option>
                    <option>MRD700</option>
                    <option>MRD700/IP65</option>
                    <option>Dimensionamento técnico</option>
                </select>
            </label>
            <label>Catálogo ou guia
                <select name="catalog">
                    <option>MRD600 - catálogo técnico</option>
                    <option>MRD600 - guia rápido</option>
                    <option>MRD700 - catálogo técnico</option>
                    <option>MRD700/IP65</option>
                    <option>Quero ajuda para escolher</option>
                </select>
            </label>
            <label>Potência do motor<input name="power" placeholder="Ex.: 3 cv / 2.2 kW"></label>
            <label>Tensão disponivel<input name="voltage" placeholder="Ex.: 220 V / 380 V"></label>
        </div>
        <label>Aplicação<textarea name="application" rows="3" placeholder="Ex.: bomba, esteira, ventilador, máquina industrial"></textarea></label>
        <label>Mensagem<textarea name="message" rows="4" placeholder="Descreva o que precisa: orçamento, ficha, prazo, troca de inversor, suporte técnico..."></textarea></label>
        <label>Anexo opcional<input type="file" name="attachment" accept="image/*,video/*,.pdf"></label>
        <div class="contact-actions">
            <button class="btn" type="submit">Enviar pelo WhatsApp</button>
            <a class="btn btn-secondary" href="/#contato">Voltar</a>
        </div>
    </form>
</section>
