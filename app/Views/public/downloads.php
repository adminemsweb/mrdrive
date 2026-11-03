<?php
$downloadGroups = [
    [
        'title' => 'Catálogos',
        'items' => [
            ['SCKR1-380 - Catálogo técnico em português', 'PDF · Português', asset('img/mrd380/SCKR1-380-catalogo-pt-BR.pdf')],
            ['MRD600 - Catálogo técnico', 'PDF', asset('img/mrd600/MRD600.pdf')],
            ['MRD700 - Catálogo técnico', 'PDF', asset('img/mrd700/MRD700.pdf')],
        ],
    ],
    [
        'title' => 'Características técnicas',
        'items' => [
            ['Linha SCKR1-380', 'Página técnica', '/sckr1-380'],
            ['Linha MRD600', 'Página técnica', '/mrd600'],
            ['Linha MRD700', 'Página técnica', '/mrd700'],
            ['MRD700/IP65', 'Página técnica', '/mrd700-ip65'],
        ],
    ],
    [
        'title' => 'Manuais e guias rápidos',
        'items' => [
            ['SCKR1-380 - Referência técnica de partida suave em português', 'PDF · Português', asset('img/mrd380/SCKR1-380-catalogo-pt-BR.pdf')],
            ['Guia rápido MRD600', 'PDF', asset('img/mrd600/mrd600_guia_rapido.pdf')],
            ['Guia rápido MRD700', 'PDF', asset('img/mrd700/mrd700guia_rapido.pdf')],
        ],
    ],
    [
        'title' => 'Apresentação',
        'items' => [
            ['Solicitar apresentação comercial', 'Atendimento', '/ticket'],
        ],
    ],
    [
        'title' => 'Arquivos CAD',
        'items' => [
            ['Solicitar arquivo CAD para projeto', 'Atendimento técnico', '/ticket'],
        ],
    ],
];

if (!empty($documents)) {
    $adminItems = [];
    foreach ($documents as $document) {
        $adminItems[] = [
            (string) ($document['name'] ?? 'Documento MRDRIVES'),
            ucfirst((string) ($document['type'] ?? 'Documento')),
            upload_url($document['file_path'] ?? ''),
        ];
    }

    if ($adminItems) {
        array_unshift($downloadGroups, [
            'title' => 'Documentos MRDRIVES',
            'items' => $adminItems,
        ]);
    }
}
$manuals = [];
if (!empty($samwhaDownloads['data'])) {
    foreach ($samwhaDownloads['data'] as $product) {
        $manual = \App\Services\SamwhaService::asset($product['manual_path'] ?? null);
        if ($manual !== '') { $manuals[] = [$product['name'], 'Manual técnico · Samwha DSP', $manual]; }
    }
}
?>

<section class="downloads-page">
    <div class="downloads-shell">
        <div class="downloads-heading">
            <p class="eyebrow">Downloads</p>
            <h1>Materiais técnicos MRDRIVES</h1>
        </div>

        <div class="downloads-tabs" aria-label="Categorias de downloads">
            <a href="#documentos" data-download-tab aria-current="page">Documentos gerais</a>
            <a href="#manuais-samwha" data-download-tab>Manuais Samwha DSP <small>(<?= count($manuals) ?>)</small></a>
        </div>

        <div class="downloads-list" id="documentos" data-download-panel>
            <?php foreach ($downloadGroups as $index => $group): ?>
                <details class="downloads-row" <?= str_starts_with($group['title'], 'Manuais técnicos Samwha') ? 'id="manuais-samwha"' : '' ?> <?= $index === 0 ? 'open' : '' ?>>
                    <summary>
                        <span><?= e($group['title']) ?></span>
                        <span class="downloads-plus" aria-hidden="true"></span>
                    </summary>
                    <div class="downloads-files">
                        <?php foreach ($group['items'] as $item): ?>
                            <?php $opensDocument = str_ends_with(strtolower((string) $item[2]), '.pdf'); ?>
                            <a class="downloads-file" href="<?= e($item[2]) ?>" <?= $opensDocument ? 'target="_blank" rel="noopener"' : '' ?>>
                                <span><?= e($item[0]) ?></span>
                                <small><?= e($item[1]) ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
        <section id="manuais-samwha" class="samwha-download-panel" data-download-panel aria-labelledby="samwha-manual-title">
            <div class="samwha-download-toolbar"><div><h2 id="samwha-manual-title">Manuais Samwha DSP</h2><p><span data-manual-count><?= count($manuals) ?></span> manuais disponíveis</p></div><label for="manual-search">Buscar manual<input id="manual-search" type="search" placeholder="Nome do produto ou modelo" data-manual-search></label></div>
            <?php if (!empty($samwhaDownloads['unavailable'])): ?><p role="status"><?= !empty($samwhaDownloads['stale']) ? 'Exibindo os manuais da última consulta disponível.' : 'Os manuais estão temporariamente indisponíveis. Tente novamente mais tarde.' ?></p><?php endif; ?>
            <div class="samwha-download-list">
                <?php foreach ($manuals as $manual): ?><a class="samwha-download-file" data-manual-file href="<?= e($manual[2]) ?>" target="_blank" rel="noopener"><span class="samwha-pdf-label">PDF</span><span class="samwha-download-name"><?= e($manual[0]) ?><small>Manual técnico · Samwha DSP</small></span><span class="samwha-download-action">Baixar <span aria-hidden="true">↓</span></span></a><?php endforeach; ?>
            </div>
            <p data-manual-empty <?= $manuals ? 'hidden' : '' ?>>Nenhum manual disponível para esta busca.</p>
        </section>
    </div>
</section>
<script src="<?= versioned_asset('js/downloads.js') ?>" defer></script>
