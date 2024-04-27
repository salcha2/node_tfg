function GeoLayers(){
    this.vectorGeoJson=null;
}

GeoLayers.prototype.ObtenerLayersBase = function(){
    var listaLayers = [];
    
    var lyrOSM = new ol.layer.Tile({
        title:'Open Street Map',
        visible: true,
        baseLayer:true,
        source: new ol.source.OSM()
    });
    listaLayers.push(lyrOSM);

    var lyrGoogleMap = new ol.layer.Tile({
        title:'Google Maps',
        visible: false,
        baseLayer:true,
        source: new ol.source.XYZ({
            url: "https://mt1.google.com/vt/lyrs=r&x={x}&y={y}&z={z}"
        })
    });
    listaLayers.push(lyrGoogleMap);

        
    var lyrGoogleMapS = new ol.layer.Tile({
        title:'Google Maps Satelite',
        visible: false,
        baseLayer:true,
        source: new ol.source.XYZ({
            url: "http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}"
        })
    });
    listaLayers.push(lyrGoogleMapS);

    return new ol.layer.Group({
        title:'Capas Base',
        layers:listaLayers
    });
};

GeoLayers.prototype.ObtenerLayersSobrepuestos=function(){
    var listaLayers = [];
    
	var lyrManzana = new ol.layer.Tile({
        title:'Manzana',
        visible:true,
        source:new ol.source.TileWMS({
            url:'http://localhost:8080/geoserver/wms?',
            params:{
                VERSION:'1.1.1',
                FORMAT:'image/png',
                TRANSPARENT:true,
                LAYERS:'datos4:datos4'
            }
        })
    })
    listaLayers.push(lyrManzana);

    var lyrPunto = new ol.layer.Tile({
        title:'Punto',
        visible:true,
        source:new ol.source.TileWMS({
            url:'http://localhost:8080/geoserver/wms?',
            params:{
                VERSION:'1.1.1',
                FORMAT:'image/png',
                TRANSPARENT:true,
                STYLES:'punto',
                LAYERS:'datos4:datos4'
            }
        })
    })
    listaLayers.push(lyrPunto);

    return new ol.layer.Group({
        title:'Capas Sopbrepuestas',
        layers:listaLayers
    });
}

GeoLayers.prototype.ObtenerLayersGeoJSON= function(){
    var lista = [];

    this.vectorGeoJson = new ol.source.Vector({
        url:'resources/punto.json',
        format: new ol.format.GeoJSON()
    });

    var lyrGeojson = new ol.layer.Vector({
        title:'Punto Geojson',
        style: new ol.style.Style({
            image: new ol.style.Icon({
                src:'resources/iconos/condominium.png'
            })
        }),
        source:this.vectorGeoJson
    });
    lista.push(lyrGeojson);

    return new ol.layer.Group({
        title:'Capas GeoJson',
        visible: false,
        layers: lista
    })
}