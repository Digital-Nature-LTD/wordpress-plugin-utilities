<?php
use DigitalNature\Utilities\Config\PluginConfig;
?>
<template id="digital-nature-loading-overlay-template">
    <link rel="stylesheet" href="<?= PluginConfig::get_plugin_url(); ?>assets/admin/css/dn-utilities-admin.css" media="all">
    <link rel="stylesheet" href="<?= PluginConfig::get_plugin_url(); ?>assets/common/css/dn-utilities-common.css" media="all">
    <link rel="stylesheet" href="<?= PluginConfig::get_plugin_url(); ?>assets/common/css/dn-utilities-web-components.css" media="all">

    <slot name="upper-text"></slot>
    <slot name="lower-text"></slot>

    <style>
        :host {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: rgba(255, 255, 255, 0.8);

            display: none;
            grid-template-rows: 1fr var(--font-size-paragraph) 100px var(--font-size-paragraph) 1fr;
            grid-template-columns: 1fr 100px 1fr;
            grid-template-areas: "topl topc topr" "uppertextl uppertextc uppertextr" "imagel imagec imager" "lowertextl lowertextc lowertextr" "bottoml bottomc bottomr";
            gap: 0;
            padding: 0;

            &:before {
                content: '';
                grid-area: imagec;
                height: 100px;
                width: 100px;
            }
        }

        :host(.populated) {
            display: grid;
        }

        slot[name="upper-text"] {
            grid-area: uppertextc;
            grid-column-start: uppertextl;
            grid-column-end: uppertextr;
        }

        slot[name="lower-text"] {
            grid-area: lowertextc;
            grid-column-start: lowertextl;
            grid-column-end: lowertextr;
        }

        slot[name="upper-text"],
        slot[name="lower-text"] {
            display: block;
            text-align: center;
            align-self: center;
            font-size: var(--font-size-paragraph-small);
            text-wrap: nowrap;
            animation: dnFadeInOutRepeat 2.5s infinite;

            p {
                padding: 0;
                margin: 0;
                font-size: var(--font-size-paragraph-small);
            }
        }
    </style>
</template>