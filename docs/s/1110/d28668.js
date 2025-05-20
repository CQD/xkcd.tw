function eventPos(e) {
    if(e.type.match(/^touch/)) {
        e = e.originalEvent.changedTouches[0];
    }
    return {pageX: e.pageX, pageY: e.pageY};
}

var Map=function($container){
    var $overlay = $container.children('img');
    $overlay.css({
        background: 'transparent',
        position: 'relative'
    });

    $container.css({
        'z-index': 1,
        overflow: 'hidden',
        height: $overlay.css('height'),
        display: 'inline-block',
        margin: '0px auto 0',
        padding:0,
        background: '#fff',
        position: 'relative'
    });

    $(window).on('resize', function(){
        $container.css({height: $overlay.css('height')});
    });

    var sign=function(x){return x>0?+1:x<0?-1:0;};
    var pow=function(x,y){return Math.pow(Math.abs(x),y)*sign(x);}
    var clamp=function(x,min,max){return Math.max(Math.min(x,max),min);}

    var offset=$container.offset();

    var padding_top=200;
    var size=[14,48,25,33];
    var tilesize=2048;
    var visible=[];
    var container_size=[$container.width(),$container.height()];
    var scroll_delta=null;

    var $map=$container.children('.map');

    var map_size=[(size[1]+size[3])*tilesize,(size[0]+size[2])*tilesize];
    $map.css({
        width: map_size[0],
        height: map_size[1],
        position: 'absolute',
        zIndex: -1
    });

     position=[-(size[3]+0.03)*tilesize,-(size[0]-0.44)*tilesize + (222 * ($overlay.height() / 694))];

    $map.find('.ground').css({
        top: size[0]*tilesize,
        height: size[2]*tilesize,
        position: 'absolute',
        width: '100%',
        zIndex: -1,
        background: '#000'
    });

    var centre=[-1,0];

    var update=function(){
        $map.css({
            left:position[0],
            top:position[1]
        });

        var centre_last=centre;
        centre=[Math.floor(-position[0]/tilesize),Math.floor(-position[1]/tilesize)];

        tile_name=function(x,y){
            x-=size[3];
            y-=size[0];
            return (y>=0?(y+1)+'s':-y+'n')+(x>=0?(x+1)+'e':-x+'w');
        };

        if(centre[0]!=centre_last[0]||centre[1]!=centre_last[1]){
            var $remove=$map.children().not('.ground');

            for(var y=-1;y<=+1;y++)
            for(var x=-1;x<=+1;x++){
                var name=tile_name(centre[0]+x,centre[1]+y);
                if (!mapTileExists(name)) {
                    continue;
                }
                var tile=$map.find('.tile'+name);
                if(tile.length){
                    $remove=$remove.not(tile);
                }else{
                    $image=$('<img class="tile'+name+'" src="/s/1110/'+name+'.png" style="top:'+((centre[1]+y)*tilesize)+'px;left:'+((centre[0]+x)*tilesize)+'px; z-index: -1; position: absolute;;" style="display:none" />');
                    $image.on('load', function(){$(this).show()}).on('error', function(){$(this).remove();});
                    $map.append($image);
                }
            }

            $remove.remove();
        }
    }

    update();

    function drag(e){
        if(scroll_delta){
            var pos = eventPos(e);
            position[0]=Math.round(clamp(pos.pageX+scroll_delta[0],-(size[1]+size[3])*tilesize+container_size[0],0));
            position[1]=Math.round(clamp(pos.pageY+scroll_delta[1],-(size[0]+size[2])*tilesize+container_size[1],0));
            update();
        }
    }

    $container
        .on('mousedown touchstart', function(e){
            if(e.button && e.button >= 2){
                return;
            }
            var pos = eventPos(e);
            scroll_delta=[position[0]-pos.pageX,position[1]-pos.pageY];
            $(document).on(e.type == 'mousedown' ? 'mousemove' : 'touchmove', drag);
            e.preventDefault();
        })
    ;
    $(document)
        .on('mouseup touchend', function(e){
            $(document).off('mousemove touchmove', drag)
            scroll_delta=null;
        })
    ;
};

/* 50:72:6f:50:75:6b:65:20:69:73:20:61:77:65:73:6f:6d:65 */

$(function(){
    var map=new Map($('#comic'));
});

function mapTileExists(name){
    var tiles = ['10s17w','10s7e','11n11e','11n11w','11s11e','11s11w','11s17w','11s7e','12s10w','12s11w',
        '12s12w','12s13w','12s14w','12s15w','12s16w','12s17w','12s7e','12s8w','12s9w','13n1e','13s6w','13s7e',
        '13s7w','13s8w','14s1e','14s1w','14s2e','14s2w','14s3e','14s3w','14s4w','14s5w','14s6w','14s7e',
        '14s7w','15s1e','15s1w','15s7e','16s1e','16s6e','16s7e','16s8e','17s1e','17s2e','17s3e','17s5e',
        '17s6e','17s7e','17s8e','18s3e','18s4e','18s8e','19s4e','19s5e','19s6e','19s7e','19s8e','1n10e',
        '1n10w','1n11e','1n11w','1n12e','1n12w','1n13e','1n13w','1n14e','1n14w','1n15e','1n15w','1n16e',
        '1n16w','1n17e','1n17w','1n18e','1n18w','1n19e','1n19w','1n1e','1n1w','1n20e','1n20w','1n21e',
        '1n21w','1n22e','1n22w','1n23e','1n23w','1n24e','1n24w','1n25e','1n25w','1n26e','1n26w','1n27e',
        '1n27w','1n28e','1n28w','1n29e','1n29w','1n2e','1n2w','1n30e','1n30w','1n31e','1n31w','1n32e',
        '1n32w','1n33e','1n33w','1n34e','1n35e','1n36e','1n37e','1n38e','1n39e','1n3e','1n3w','1n40e',
        '1n41e','1n42e','1n43e','1n44e','1n45e','1n46e','1n47e','1n48e','1n4e','1n4w','1n5e','1n5w',
        '1n6e','1n6w','1n7e','1n7w','1n8e','1n8w','1n9e','1n9w','1s17w','1s6w','1s7e','2n16e','2n17e',
        '2n1w','2n22e','2n22w','2n23e','2n24e','2n25e','2n26e','2n27e','2n28e','2n29e','2n2w','2n30e',
        '2n31e','2n32e','2n39e','2n3e','2n3w','2n4e','2n4w','2n5e','2n6e','2s17w','2s7e','2s9w','3n10e',
        '3n18e','3n23e','3n24e','3n25e','3n26e','3n27e','3n28e','3n29e','3n2e','3n2w','3n30e','3n31e',
        '3n3e','3n3w','3s17w','3s7e','4n24e','4n25e','4n26e','4n27e','4n28e','4n29e','4n2w','4n30e',
        '4s17w','4s7e','5n12e','5n1w','5n25e','5n26e','5n27e','5n28e','5n29e','5n2w','5s17w','5s7e',
        '6n1e','6n26e','6n27e','6n28e','6n2w','6n5w','6s17w','6s7e','7n27e','7n2w','7n7w','7s17w',
        '7s7e','8n1w','8n2w','8n6e','8s17w','8s7e','9n2e','9s17w','9s7e'];
    return $.inArray(name, tiles) >= 0;
}
