<?php
$downloadGroups = [
    [
        'title' => 'Catálogos',
        'items' => [
            ['MRD600 - Catálogo técnico', 'PDF', asset('img/mrd600/MRD600.pdf')],
            ['MRD700 - Catálogo técnico', 'PDF', asset('img/mrd700/MRD700.pdf')],
        ],
    ],
    [
        'title' => 'Características técnicas',
        'items' => [
            ['Linha MRD600', 'Página técnica', '/mrd600'],
            ['Linha MRD700', 'Página técnica', '/mrd700'],
            ['MRD700/IP65', 'Página técnica', '/mrd700-ip65'],
        ],
    ],
    [
        'title' => 'Manuais e guias rápidos',
        'items' => [
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
?>

<section class="downloads-page">
    <div class="downloads-shell">
        <div class="downloads-heading">
            <p class="eyebrow">Downloads</p>
            <h1>Materiais técnicos MRDRIVES</h1>
        </div>

        <div class="downloads-tabs" aria-label="Categorias de downloads">
            <a href="#documentos">Documentos gerais</a>
        </div>

        <div class="downloads-list" id="documentos">
            <?php foreach ($downloadGroups as $index => $group): ?>
                <details class="downloads-row" <?= $index === 0 ? 'open' : '' ?>>
                    <summary>
                        <span><?= e($group['title']) ?></span>
                        <span class="downloads-plus" aria-hidden="true"></span>
                    </summary>
                    <div class="downloads-files">
                        <?php foreach ($group['items'] as $item): ?>
                            <?php $opensDocument = str_ends_with(strtolower((string) $item[2]), '.pdf'); ?>
                            <a class="downloads-file" href="<?= e($item[2]) ?>" <?= $opensDocument ? 'target="_blank"' : '' ?>>
                                <span><?= e($item[0]) ?></span>
                                <small><?= e($item[1]) ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
