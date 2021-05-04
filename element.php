<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return Str::length($node->props['title'])
                || Str::length($node->props['meta'])
                || Str::length($node->props['content'])
                || $node->props['image']
                || $node->props['icon'];

        },

    ],

    'updates' => [

        '2.1.0-beta.0.1' => function ($node) {

            if (@$node->props['title_grid_width'] === 'xxlarge') {
                $node->props['title_grid_width'] = '2xlarge';
            }

            if (@$node->props['image_grid_width'] === 'xxlarge') {
                $node->props['image_grid_width'] = '2xlarge';
            }

            if (!empty($node->props['icon_ratio'])) {
                $node->props['icon_width'] = round(20 * $node->props['icon_ratio']);
                unset($node->props['icon_ratio']);
            }

        },

        '2.0.0-beta.5.1' => function ($node) {

            if (@$node->props['link_type'] === 'content') {
                $node->props['title_link'] = true;
                $node->props['image_link'] = true;
                $node->props['link_text'] = '';
            } elseif (@$node->props['link_type'] === 'element') {
                $node->props['panel_link'] = true;
                $node->props['link_text'] = '';
            }
            unset($node->props['link_type']);

        },

        '1.22.0-beta.0.1' => function ($node) {

            if (isset($node->props['title_gutter'])) {
                $node->props['title_grid_column_gap'] = $node->props['title_gutter'];
                $node->props['title_grid_row_gap'] = $node->props['title_gutter'];
                unset($node->props['title_gutter']);
            }

            if (isset($node->props['title_breakpoint'])) {
                $node->props['title_grid_breakpoint'] = $node->props['title_breakpoint'];
                unset($node->props['title_breakpoint']);
            }

            if (isset($node->props['image_gutter'])) {
                $node->props['image_grid_column_gap'] = $node->props['image_gutter'];
                $node->props['image_grid_row_gap'] = $node->props['image_gutter'];
                unset($node->props['image_gutter']);
            }

            if (isset($node->props['image_breakpoint'])) {
                $node->props['image_grid_breakpoint'] = $node->props['image_breakpoint'];
                unset($node->props['image_breakpoint']);
            }

        },

        '1.20.0-beta.1.1' => function ($node) {

            if (isset($node->props['maxwidth_align'])) {
                $node->props['block_align'] = $node->props['maxwidth_align'];
                unset($node->props['maxwidth_align']);
            }

        },

        '1.20.0-beta.0.1' => function ($node) {

            if (@$node->props['title_style'] === 'heading-hero') {
                $node->props['title_style'] = 'heading-xlarge';
            }

            if (@$node->props['title_style'] === 'heading-primary') {
                $node->props['title_style'] = 'heading-medium';
            }

            /**
             * @var Config $config
             */
            $config = app(Config::class);

            list($style) = explode(':', $config('~theme.style'));

            if (in_array($style, ['craft', 'district', 'jack-backer', 'tomsen-brody', 'vision', 'florence', 'max', 'nioh-studio', 'sonic', 'summit', 'trek'])) {

                if (@$node->props['title_style'] === 'h1' || (empty($node->props['title_style']) && @$node->props['title_element'] === 'h1')) {
                    $node->props['title_style'] = 'heading-small';
                }

            }

            if (in_array($style, ['florence', 'max', 'nioh-studio', 'sonic', 'summit', 'trek'])) {

                if (@$node->props['title_style'] === 'h2') {
                    $node->props['title_style'] = @$node->props['title_element'] === 'h1' ? '' : 'h1';
                } elseif (empty($node->props['title_style']) && @$node->props['title_element'] === 'h2') {
                    $node->props['title_style'] = 'h1';
                }

            }

            if (in_array($style, ['fuse', 'horizon', 'joline', 'juno', 'lilian', 'vibe', 'yard'])) {

                if (@$node->props['title_style'] === 'heading-medium') {
                    $node->props['title_style'] = 'heading-small';
                }

            }

            if (in_array($style, ['copper-hill'])) {

                if (@$node->props['title_style'] === 'heading-medium') {
                    $node->props['title_style'] = @$node->props['title_element'] === 'h1' ? '' : 'h1';
                } elseif (@$node->props['title_style'] === 'h1') {
                    $node->props['title_style'] = @$node->props['title_element'] === 'h2' ? '' : 'h2';
                } elseif (empty($node->props['title_style']) && @$node->props['title_element'] === 'h1') {
                    $node->props['title_style'] = 'h2';
                }

            }

            if (in_array($style, ['trek', 'fjord'])) {

                if (@$node->props['title_style'] === 'heading-medium') {
                    $node->props['title_style'] = 'heading-large';
                }

            }

            if (in_array($style, ['juno', 'vibe', 'yard'])) {

                if (@$node->props['title_style'] === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-medium';
                }

            }

            if (in_array($style, ['district', 'florence', 'flow', 'nioh-studio', 'summit', 'vision'])) {

                if (@$node->props['title_style'] === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-large';
                }

            }

            if (in_array($style, ['lilian'])) {

                if (@$node->props['title_style'] === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-2xlarge';
                }

            }

        },

        '1.19.0-beta.0.1' => function ($node) {

            if (@$node->props['meta_align'] === 'top') {
                $node->props['meta_align'] = 'above-title';
            }

            if (@$node->props['meta_align'] === 'bottom') {
                $node->props['meta_align'] = 'below-title';
            }

            if (@$node->props['link_style'] === 'panel') {
                if (@$node->props['panel_style']) {
                    $node->props['link_type'] = 'element';
                } else {
                    $node->props['link_type'] = 'content';
                }
                $node->props['link_style'] = 'default';
            }

            if (isset($node->props['image_card'])) {
                $node->props['panel_card_image'] = $node->props['image_card'];
                unset($node->props['image_card']);
            }

        },

        '1.18.10.3' => function ($node) {

            if (@$node->props['meta_align'] === 'top') {
                if (!empty($node->props['meta_margin'])) {
                    $node->props['title_margin'] = $node->props['meta_margin'];
                }
                $node->props['meta_margin'] = '';
            }

        },

        '1.18.10.1' => function ($node) {

            if (isset($node->props['image_inline_svg'])) {
                $node->props['image_svg_inline'] = $node->props['image_inline_svg'];
                unset($node->props['image_inline_svg']);
            }

            if (isset($node->props['image_animate_svg'])) {
                $node->props['image_svg_animate'] = $node->props['image_animate_svg'];
                unset($node->props['image_animate_svg']);
            }

        },

        '1.18.0' => function ($node) {

            if (!isset($node->props['image_box_decoration']) && @$node->props['image_box_shadow_bottom'] === true) {
                $node->props['image_box_decoration'] = 'shadow';
            }

            if (!isset($node->props['meta_color']) && @$node->props['meta_style'] === 'muted') {
                $node->props['meta_color'] = 'muted';
                $node->props['meta_style'] = '';
            }

        },

    ],

];
