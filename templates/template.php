<?php

// Resets
if ($props['icon'] && !$props['image']) { $props['panel_card_image'] = ''; }
if ($props['panel_style'] || !$props['image']) { $props['image_box_decoration'] = ''; }
if ($props['panel_link']) {
    $props['title_link'] = '';
    $props['image_link'] = '';
}

// New logic shortcuts
$props['has_panel_card_image'] = $props['image'] && $props['panel_card_image'] && $props['image_align'] != 'between';
$props['has_panel_content_padding'] = $props['image'] && $props['panel_content_padding'] && $props['image_align'] != 'between';

// Image
$props['image'] = $this->render("{$__dir}/template-image", compact('props'));

if ($props['image_transition']) {

    $transition_toggle = $this->el('div', [
        'class' => [
            'uk-inline-clip [uk-transition-toggle {@image_link}]',
            'uk-border-{image_border}' => !$props['panel_style'] || ($props['panel_style'] && (!$props['panel_card_image'] || $props['image_align'] == 'between')),
            'uk-box-shadow-{image_box_shadow} {@!panel_style}',
            'uk-box-shadow-hover-{image_hover_box_shadow} {@!panel_style} {@link}' => $props['image_link'] || $props['panel_link'],
            'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@!image_box_decoration}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_card_image'])),
        ],
    ]);
    $props['image'] = $transition_toggle($props, $props['image']);

}

if ($props['image_box_decoration']) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_card_image'])),
        ],

    ]);

    $props['image'] = $decoration($props, $props['image']);
}

// Panel/Card
$el = $this->el($props['link'] && $props['panel_link'] ? 'a' : 'div', [

    'class' => [
        'uk-panel {@!panel_style}',
        'uk-card uk-{panel_style} [uk-card-{panel_size}]',
        'uk-card-hover {@!panel_style: |card-hover} {@panel_link} {@link}',
        'uk-card-body {@panel_style} {@!has_panel_card_image}',
        'uk-margin-remove-first-child' => (!$props['panel_style'] && !$props['has_panel_content_padding']) || ($props['panel_style'] && !$props['has_panel_card_image']),
        'uk-flex {@panel_style} {@has_panel_card_image} {@image_align: left|right}', // Let images cover the card height if the cards have different heights
        'uk-transition-toggle {@image} {@image_transition} {@panel_link}',
    ],

]);

// Image align
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['panel_style'] && $props['has_panel_card_image']
            ? 'uk-grid-collapse uk-grid-match'
            : ($props['image_grid_column_gap'] == $props['image_grid_row_gap']
                ? 'uk-grid-{image_grid_column_gap}'
                : '[uk-grid-column-{image_grid_column_gap}] [uk-grid-row-{image_grid_row_gap}]'),
        'uk-flex-middle {@image_vertical_align}',
    ],

    'uk-grid' => true,
]);

$cell_image = $this->el('div', [

    'class' => [
        'uk-width-{image_grid_width}[@{image_grid_breakpoint}]',
        'uk-flex-last[@{image_grid_breakpoint}] {@image_align: right}',
    ],

]);

// Content
$content = $this->el('div', [

    'class' => [
        'uk-card-body uk-margin-remove-first-child {@panel_style} {@has_panel_card_image}',
        'uk-padding[-{!panel_content_padding: |default}] uk-margin-remove-first-child {@!panel_style} {@has_panel_content_padding}',
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => (!$props['panel_style'] && !$props['has_panel_content_padding']) || ($props['panel_style'] && !$props['has_panel_card_image']),
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Card media
if ($props['panel_style'] && $props['has_panel_card_image']) {
    $props['image'] = $this->el('div', ['class' => [
        'uk-card-media-{image_align}',
        'uk-cover-container{@image_align: left|right}',
    ]], $props['image'])->render($props);
}

?>

<?= $el($props, $attrs) ?>

    <?php if ($props['image'] && in_array($props['image_align'], ['left', 'right'])) : ?>

        <?= $grid($props) ?>
            <?= $cell_image($props, $props['image']) ?>
            <?= $cell_content($props) ?>

                <?php if ($this->expr($content->attrs['class'], $props)) : ?>
                    <?= $content($props, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
                <?php else : ?>
                    <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
                <?php endif ?>

            <?= $cell_content->end() ?>
        </div>

    <?php else : ?>

        <?php if ($props['image_align'] == 'top') : ?>
        <?= $props['image'] ?>
        <?php endif ?>

        <?php if ($this->expr($content->attrs['class'], $props)) : ?>
            <?= $content($props, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
        <?php else : ?>
            <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
        <?php endif ?>

        <?php if ($props['image_align'] == 'bottom') : ?>
        <?= $props['image'] ?>
        <?php endif ?>

    <?php endif ?>

<?= $el->end() ?>
