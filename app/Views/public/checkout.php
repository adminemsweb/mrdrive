<nav class="shop-breadcrumb" aria-label="Navegação estrutural"><a href="/">Início</a><span>/</span><a href="/catalogo">Loja</a><span>/</span><strong>Finalizar pedido</strong></nav>
<section class="checkout-page">
    <header class="checkout-heading"><span class="shop-kicker">Finalização assistida</span><h1>Revise seu pedido</h1><p>Preencha os dados para enviarmos o resumo completo à equipe MR Drives.</p></header>
    <div class="checkout-layout">
        <form class="checkout-form" data-checkout-form>
            <section class="checkout-card">
                <div class="checkout-card-title"><span>1</span><div><h2>Dados de contato</h2><p>Usaremos estes dados para confirmar configuração, pagamento e entrega.</p></div></div>
                <div class="checkout-fields">
                    <label class="checkout-field-full">Nome ou razão social<input name="name" required autocomplete="name" placeholder="Como podemos chamar você?"></label>
                    <label>E-mail<input type="email" name="email" required autocomplete="email" placeholder="voce@empresa.com.br"></label>
                    <label>WhatsApp<input name="phone" required autocomplete="tel" placeholder="(11) 99999-9999"></label>
                    <label>CPF ou CNPJ<input name="document" autocomplete="off" placeholder="Para emissão do pedido"></label>
                </div>
            </section>
            <section class="checkout-card" data-cep-lookup>
                <div class="checkout-card-title"><span>2</span><div><h2>Endereço de entrega</h2><p>Digite o CEP para localizar seu endereço automaticamente.</p></div></div>
                <div class="checkout-fields">
                    <label>CEP<span class="checkout-cep-control"><input name="postal_code" inputmode="numeric" maxlength="9" autocomplete="postal-code" placeholder="00000-000" required data-cep-input><button type="button" data-cep-button>Buscar CEP</button></span></label>
                    <label class="checkout-field-full">Logradouro<input name="street" autocomplete="address-line1" placeholder="Rua, avenida..." data-address-street></label>
                    <label>Número<input name="address_number" autocomplete="address-line2" placeholder="Número" required></label>
                    <label>Complemento<input name="address_complement" autocomplete="address-line3" placeholder="Sala, bloco, referência"></label>
                    <label>Bairro<input name="district" placeholder="Bairro" data-address-district></label>
                    <label>Cidade<input name="city" autocomplete="address-level2" placeholder="Cidade" data-address-city></label>
                    <label>Estado<input name="state" autocomplete="address-level1" maxlength="2" placeholder="UF" data-address-state></label>
                    <p class="checkout-cep-status checkout-field-full" data-cep-status aria-live="polite"></p>
                </div>
            </section>
            <section class="checkout-card">
                <div class="checkout-card-title"><span>3</span><div><h2>Aplicação</h2><p>Informações rápidas para validarmos a compra.</p></div></div>
                <div class="checkout-fields">
                    <label>Tipo de aplicação<select name="application"><option value="Máquina industrial">Máquina industrial</option><option value="Bomba ou ventilador">Bomba ou ventilador</option><option value="Automação / painel">Automação / painel</option><option value="Reposição">Reposição</option><option value="Outro">Outro</option></select></label>
                    <label>Urgência<select name="urgency"><option value="Prazo normal">Prazo normal</option><option value="Preciso com urgência">Preciso com urgência</option><option value="Apenas cotação">Apenas cotação</option></select></label>
                    <label class="checkout-field-full">Observações<textarea name="notes" rows="4" placeholder="Informe tensão, potência do motor ou algum detalhe importante."></textarea></label>
                </div>
            </section>
            <section class="checkout-card checkout-payment-card"><div class="checkout-card-title"><span>4</span><div><h2>Pagamento</h2><p>A cobrança bancária será habilitada na etapa de integração Santander.</p></div></div><div class="checkout-payment-notice"><strong>Pedido sem cobrança imediata</strong><p>Ao continuar, seu carrinho será enviado pelo WhatsApp. A equipe confirma estoque, frete e condição de pagamento antes de gerar a cobrança.</p></div></section>
            <button class="checkout-submit" type="submit"><span>W</span> Enviar pedido pelo WhatsApp</button>
            <p class="checkout-privacy">Ao continuar, você concorda com nossa <a href="/politica-de-privacidade">Política de Privacidade</a>.</p>
        </form>
        <aside class="checkout-summary"><div class="checkout-summary-head"><h2>Resumo do pedido</h2><button type="button" data-cart-open>Editar carrinho</button></div><div data-checkout-items></div><div class="checkout-summary-total"><span>Subtotal</span><strong data-checkout-subtotal>—</strong></div><p data-checkout-quote-note>Itens sob consulta terão o valor confirmado por nossa equipe.</p><div class="checkout-safe"><span>□</span><p><strong>Compra assistida e segura</strong>Seus dados são usados apenas para processar esta solicitação.</p></div></aside>
    </div>
</section>
