<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="/images/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>我的小站</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/app.js')}}" defer></script>
</head>

<div id="app">12345<router-view /></div>