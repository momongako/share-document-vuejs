@extends('layouts.app')

@section('content')
    <sub-menu-page
        :title-page="{{ json_encode($titlePage) }}"
        :show-option-type="{{ json_encode($showOptionType) }}"
        :list-post-category="{{ $listPostCategory }}"
        :first-post-category="{{ $firstPostCategory }}"
        :url-list-post="{{json_encode(route('' . $urlListPost))}}"
        :category-id = "{{ json_encode($categoryId) }}"
        :info-user = "{{ $infoUser }}"
        :show-button-creat = "{{ json_encode($showButtonCreat) }}"
    >
    </sub-menu-page>
@endsection

