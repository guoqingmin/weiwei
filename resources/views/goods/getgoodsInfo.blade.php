
        @foreach($res as $key=>$val)
            <dl>
                <dt>
                    <a href="proinfo/{{$val->goods_id}}" >
                        <img src="http://www.weiimg.com/{{$val->goods_img}}">
                    </a>
                </dt>
                <dd>
                    <h3><a href="proinfo/{{$val->goods_id}}">{{$val->goods_name}}</a></h3>
                    <div class="proinfo/{{$val->goods_id}}"><strong>¥{{$val->shop_price}}</strong> <span>¥{{$val->market_price}}</span></div>
                    <div class="prolist-yishou"><span>5.0折</span> <em>库存：{{$val->goods_number}}</em></div>
                </dd>
                <div class="clearfix"></div>
            </dl>
        @endforeach

