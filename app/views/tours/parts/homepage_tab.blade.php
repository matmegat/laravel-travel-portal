<div class="col-md-4">
    <div class="row">
        <a href="{{action('ToursController@viewProduct', array('product' => $tour['ID']))}}">
            <img src="{{$tour['photo']}}" alt="" class="img-thumbnail"/>
        </a>
        <p><h4>{{$tour['Title']}}</h4></p>
        <p>{{$tour['Supplier']['Name']}}</p>
        <p>Rates From: {{$tour['Price']}}</p>

        <div style="height: 150px; overflow: hidden;">
            {{ StringHelper::clearText($tour['description']) }}
        </div>

        <div class="clearfix"></div>
        <a href="{{action('ToursController@viewProduct', array('product' => $tour['ID']))}}">
            <button class="btn btn-default">VIEW MORE INFO</button>
        </a>

    </div>
</div>