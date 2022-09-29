@extends('admin.adminmasterlayout')
@section('title', 'Class Layout')
@section('description', 'Cooking Point Admin Main Page')
@section('content')
<script type="text/javascript">
function show_cooking_layout () {
  var x;
  x = document.getElementsByClassName("tg-white")
  for (var i = 0; i < x.length; i++) {
    x[i].style.backgroundColor = "white"
  }
  @foreach($cooking as $position)
  x = document.getElementById("tg-{{$position}}")
  x.style.backgroundColor = "orange"
  @endforeach
};

function show_eating_layout () {
  var x;
  x = document.getElementsByClassName("tg-white")
  for (var i = 0; i < x.length; i++) {
    x[i].style.backgroundColor = "white"
  }
  @foreach($eating as $position)
  x = document.getElementById("tg-{{$position}}")
  x.style.backgroundColor = "DarkKhaki"
  @endforeach
};
</script>

<div class="row justify-content-center">
  <div class="col-md-6 text-center">
    <button onclick="show_cooking_layout()" class="btn btn-primary btn-sm mb-1 me-1">Cocinando</button>
    <button onclick="show_eating_layout()" class="btn btn-secondary btn-sm mb-1">Comiendo</button>
  </div>
</div>

<div class="row justify-content-center">
  @if ($test ?? 0)
  <div class="col-xl-1">
    <form method="get" action="layouttest">
      @csrf
      <input type="number" name="group1" value="{{$group1 ?? 0}}">
      <input type="number" name="group2" value="{{$group2 ?? 0}}">
      <input type="number" name="group3" value="{{$group3 ?? 0}}">
      <button type="submit">View</button>
    </form>
  </div>
  @endif
  <div class="col-md-6 col-xl-4">
    <div style="height: 5px; background-color: orange;"></div>
    <style type="text/css">
    @foreach($cooking as $position) #tg-{{ $position }}
    {
      background-color: orange;
    }

    @endforeach .tg {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      height: 70vh;
    }

    .tg td {
      border-color: lightgray;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 18px;
      overflow: hidden;
      word-break: normal;
      text-align: center;
      vertical-align: middle;
      width: 20%;
      height: 8%;
    }

    .tg .tg-gutter {
      height: 1%;
    }

    .tg .tg-stove {
      background-color: darkgray;
    }

    .tg .tg-white {
      background-color: white;
    }

    </style>
    <table class="tg">
      <tbody>
        <tr>
          <td id="tg-82" class="tg-white">82</td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td id="tg-11" class="tg-white">11</td>
        </tr>
        <tr>
          <td class="tg-stove"></td>
          <td class="tg-stove">8</td>
          <td class="tg-white"></td>
          <td class="tg-stove">1</td>
          <td class="tg-stove"></td>
        </tr>
        <tr>
          <td id="tg-81" class="tg-white">81</td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td id="tg-12" class="tg-white">12</td>
        </tr>
        <tr>
          <td class="tg-gutter" colspan="5"></td>
        </tr>
        <tr>
          <td id="tg-72" class="tg-white">72</td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td id="tg-21" class="tg-white">21</td>
        </tr>
        <tr>
          <td class="tg-stove"></td>
          <td class="tg-stove">7</td>
          <td class="tg-white"></td>
          <td class="tg-stove">2</td>
          <td class="tg-stove"></td>
        </tr>
        <tr>
          <td id="tg-71" class="tg-white">71</td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td id="tg-22" class="tg-white">22</td>
        </tr>
        <tr>
          <td class="tg-gutter" colspan="5"></td>
        </tr>
        <tr>
          <td id="tg-62" class="tg-white">62</td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td id="tg-31" class="tg-white">31</td>
        </tr>
        <tr>
          <td class="tg-stove"></td>
          <td class="tg-stove">6</td>
          <td class="tg-white"></td>
          <td class="tg-stove">3</td>
          <td class="tg-stove"></td>
        </tr>
        <tr>
          <td id="tg-61" class="tg-white">61</td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td id="tg-32" class="tg-white">32</td>
        </tr>
        <tr>
          <td class="tg-gutter" colspan="5"></td>
        </tr>
        <tr>
          <td id="tg-52" class="tg-white">52</td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td class="tg-white"></td>
          <td id="tg-41" class="tg-white">41</td>
        </tr>
        <tr>
          <td class="tg-stove"></td>
          <td class="tg-stove">5</td>
          <td class="tg-white"></td>
          <td class="tg-stove">4</td>
          <td class="tg-stove"></td>
        </tr>
        <tr>
          <td id="tg-51" class="tg-white">51</td>
          <td id="tg-45" class="tg-white"></td>
          <td id="tg-44" class="tg-white"></td>
          <td id="tg-43" class="tg-white"></td>
          <td id="tg-42" class="tg-white">42</td>
        </tr>
      </tbody>
    </table>
  </div>
  @stop
