<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('index'));
});

Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('home');
    $trail->push($category->title, route('category.indexCurrentCategory', $category->id));
});

Breadcrumbs::for('tour', function ($trail, $category, $tour) {
    $trail->parent('category', $category);
    $trail->push($tour->title, route('tour.show', $tour->id));
});

Breadcrumbs::for('scope', function ($trail, $scope) {
    $trail->parent('home');
    $trail->push($scope->title, route('scope.indexCurrentScope', $scope->id));
});

Breadcrumbs::for('page', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page->title, route('page.show', $page->id));
});