<?php

// Domov
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Hlavé menu', route('home'));
});

// Domov > Číselníky
Breadcrumbs::register('classification.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Číselníky', route('classification.index'));
});

// Domov > Číselníky > Užívatelia
Breadcrumbs::register('users.index', function($breadcrumbs)
{
    $breadcrumbs->parent('classification.index');
    $breadcrumbs->push('Užívatelia', route('users.index'));
});

// Domov > Číselníky > Užívatelia > Editácia rol
Breadcrumbs::register('users.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Editácia rol', route('users.show', $id));
});

// Domov > Číselníky > Užívatelia > Užívatelské role
Breadcrumbs::register('role.index', function($breadcrumbs)
{
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Užívatelské role', route('role.index'));
});

// Domov > Číselníky > Užívatelia > Užívatelské role > Editácia práv
Breadcrumbs::register('role.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('role.index');
    $breadcrumbs->push('Editácia práv', route('role.show', $id));
});

// Domov > Číselníky > Užívatelia > Užívatelské práva
Breadcrumbs::register('permission.index', function($breadcrumbs)
{
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Užívatelské práva', route('permission.index'));
});


?>