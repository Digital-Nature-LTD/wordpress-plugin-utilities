<?php
use DigitalNature\Utilities\Config\PluginConfig;
?>
<template id="digital-nature-dismissable-message-template">
    <link rel="stylesheet" href="<?= PluginConfig::get_plugin_url(); ?>assets/admin/css/admin.css" media="all">
    <link rel="stylesheet" href="<?= PluginConfig::get_plugin_url(); ?>assets/common/css/common.css" media="all">

    <slot name="message"></slot>
    <button class="message-close" title="Click to dismiss">Close</button>

    <style>
        :host {
            display: block;
            margin: 5px 0;
            position: relative;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1);
            padding: 10px 10px 10px 2em;
            background: var(--digital-nature-dismissable-message-info-border-colour);
            border-radius: var(--digital-nature-dismissable-message-border-radius);
        }

        :host(.success) {
            color: var(--digital-nature-dismissable-message-success-text-colour);

            button {
                border-color: var(--digital-nature-dismissable-message-success-border-colour);

                &:before {
                    background: var(--digital-nature-dismissable-message-success-dot-before-colour);
                }

                &:after {
                    background: var(--digital-nature-dismissable-message-success-dot-after-colour);
                }
            }
        }

        :host(.error) {
            color: var(--digital-nature-dismissable-message-error-text-colour);

            button {
                border-color: var(--digital-nature-dismissable-message-error-border-colour);

                &:before {
                    background: var(--digital-nature-dismissable-message-error-dot-before-colour);
                }

                &:after {
                    background: var(--digital-nature-dismissable-message-error-dot-after-colour);
                }
            }
        }

        :host(.warning) {
            color: var(--digital-nature-dismissable-message-warning-text-colour);

            button {
                border-color: var(--digital-nature-dismissable-message-warning-border-colour);

                &:before {
                    background: var(--digital-nature-dismissable-message-warning-dot-before-colour);
                }

                &:after {
                    background: var(--digital-nature-dismissable-message-warning-dot-after-colour);
                }
            }
        }

        :host(.info) {
            color: var(--digital-nature-dismissable-message-info-text-colour);

            button {
                border-color: var(--digital-nature-dismissable-message-info-border-colour);

                &:before {
                    background: var(--digital-nature-dismissable-message-info-dot-before-colour);
                }

                &:after {
                    background: var(--digital-nature-dismissable-message-info-dot-after-colour);
                }
            }
        }

        :host(:hover) {
            top: -1px;
        }

        span {
            z-index: 1;
        }

        button {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-width: 3px 3px 3px 20px;
            border-style: solid;
            border-radius: var(--digital-nature-dismissable-message-border-radius);
            background: transparent;
            cursor: pointer;
            z-index: 2;
            text-align: right;

            &:before,
            &:after {
                content: '';
                display: block;
                position: absolute;
                height: 5px;
                width: 5px;
            }

            &:before {
                left: -15px;
                bottom: 1.5em;
            }

            &:after {
                left: -10px;
                bottom: calc(1.5em - 5px);
            }
        }
    </style>
</template>