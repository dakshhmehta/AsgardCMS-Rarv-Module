<?php

Form::component('selectGroup', 'rarv::partials.form.select_group', [
    'name', 'text', 'icon', 'values', 'selected' => null, 'attributes' => [], 'col' => 'col-md-6',
]);

Form::component('numberGroup', 'rarv::partials.form.number_group', [
    'name', 'text', 'icon', 'attributes' => [], 'value' => null, 'col' => 'col-md-6',
]);

Form::component('textGroup', 'rarv::partials.form.text_group', [
    'name', 'text', 'icon', 'attributes' => [], 'value' => null, 'col' => 'col-md-6',
]);

/**
 * Deprecated by @Mahesh Baliya
 */
Form::component('textareaGroupOld', 'rarv::partials.form.textarea_group', [
    'name', 'text', 'value' => null, 'attributes' => ['rows' => '3'], 'col' => 'col-md-12',
]);
Form::component('textareaGroup', 'rarv::partials.form.textarea_group', [
    'name', 'text', 'icon', 'attributes' => ['rows' => '3'], 'value' => null, 'col' => 'col-md-12',
]);

Form::component('dateGroup', 'rarv::partials.form.date_group', [
    'name', 'text', 'icon', 'attributes' => ['type' => 'date', 'future' => true], 'value' => null, 'col' => 'col-md-6',
]);

/**
 * @deprecated Use instead dateGroup component.
 */
Form::component('datetime', 'rarv::partials.form.date_group', [
    'name', 'text', 'icon', 'attributes' => [], 'value' => null, 'col' => 'col-md-6',
]);