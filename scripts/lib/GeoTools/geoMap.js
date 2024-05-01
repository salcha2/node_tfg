
function GeoMap(){
    this.map=null;
    this.mainBarCustom =null;
    this.vector = null;
}

GeoMap.prototype.CrearMapa= function(target,layers,center,zoom){
    var _target = target || 'map',
    _layers = layers || [],
    _center = center || [-3.74922, 40.4637],
    _zoom = zoom || 6;

    this.map = new ol.Map({
        target: _target,
        layers: _layers,
        view : new ol.View({
            center: ol.proj.fromLonLat(_center),
            zoom:_zoom
        })
    });

    
    var layerSwitcher = new ol.control.LayerSwitcher({
        tipLabel: 'Leyenda', 
        groupSelectStyle: 'children' // Can be 'children' [default], 'group' or 'none'
    });

    this.map.addControl(layerSwitcher);


    var controlMousePosition = new ol.control.MousePosition({
        coordinateFormat: ol.coordinate.createStringXY(4),
        //projection: 'EPSG:4326',
        className: 'custom-mouse-position',
        target: document.getElementById('mouse-position'),
    });
    this.map.addControl(controlMousePosition);

    map = this.map;
};

GeoMap.prototype.CrearControlBarra= function(){

    /*
    var vector = new ol.layer.Vector({source: new ol.source.Vector()});
    this.map.addLayer(vector);
*/
    var mainBar = new ol.control.Bar();
    this.map.addControl(mainBar);

    mainBar.addControl(new ol.control.FullScreen());
    mainBar.addControl(new ol.control.Rotate());
    mainBar.addControl(new ol.control.ZoomToExtent({extent:[-7594031,-1859676 , -7581985,-1866098]}));
    mainBar.setPosition('top-left');

/*
    var drawBar = new ol.control.Bar({
        group:true,
        toggleOne:true
    });

    mainBar.addControl(drawBar);

    var controlDraw = new ol.control.Toggle({
        title:'Dibujar punto',
        html:'<i class="fa fa-map-marker"></i>',
        interaction: new ol.interaction.Draw({
            type:'Point',
            source: vector.getSource()
        })
        
    });
    drawBar.addControl(controlDraw);

    var controlSelect = new ol.control.Toggle({
        title:'Seleccionar punto',
        html:'<i class="fa fa-hand-pointer-o"></i>',
        active:true,
        interaction: new ol.interaction.Select(),
        onToggle:function(active){
            console.log("control activo: ", active);
        }
    });

    drawBar.addControl(controlSelect);

    var controlButton = new ol.control.Button({
        title:'Mi botón',
        html:'<i class="fa fa-bell"></i>',
        handleClick: function(event){
            console.log(event);
            alert(event);
            
        }
    });

    mainBar.addControl(controlButton);
*/
}

GeoMap.prototype.CrearControlBarraDibujo=function(){
    
    var self = this;
    
    if(!this.mainBarCustom){
        this.mainBarCustom = new ol.control.Bar();
        this.map.addControl(this.mainBarCustom);
        this.mainBarCustom.setPosition('top');
    }

    
    var estiloDibujo = new ol.style.Style({
        fill: new ol.style.Fill({
            color:'rgba(35, 163, 12, 0.5)'
        }),
        stroke: new ol.style.Stroke({
            color:'#23a30c',
            width: 5
        }),
        image: new ol.style.Circle({
            radius: 5,
            fill: new ol.style.Fill({
                color:'#23a30c'
            }),
            stroke: new ol.style.Stroke({
                color:'rgba(35, 163, 12, 0.5)',
                width: 8
            }),
        })
    });

    if(!this.vector){
        this.vector = new ol.layer.Vector({
            title:'Capa de dibujo',
            displayInLayerSwitcher: false,
            source: new ol.source.Vector(),
            style:estiloDibujo
        });
        this.map.addLayer(this.vector);
    }

    var barraDibujo = new ol.control.Bar({
        group:true,
        toggleOne:true
    });
    this.mainBarCustom.addControl(barraDibujo);


    var controlModificar = new ol.interaction.Modify({source:this.vector.getSource()});
    this.map.addInteraction(controlModificar);

    var controlPunto =  new ol.control.Toggle({
        title:'Dibujar punto',
        html:'<i class="fa fa-map-marker"></i>',
        interaction: new ol.interaction.Draw({
            type:'Point',
            source:this.vector.getSource()
        })
    });
    barraDibujo.addControl(controlPunto);

    var controlLinea =  new ol.control.Toggle({
        title:'Dibujar línea',
        html:'<i class="fa fa-share-alt"></i>',
        interaction: new ol.interaction.Draw({
            type:'LineString',
            source:this.vector.getSource()
        }),
        bar: new ol.control.Bar({
            controls:[
                new ol.control.TextButton({
                    title:'Deshacer ultimo punto',
                    html:'Deshacer',
                    handleClick:function(){
                        controlLinea.getInteraction().removeLastPoint()
                    }
                }),
                new ol.control.TextButton({
                    title:'Finalizar dibujo',
                    html:'Finalizar',
                    handleClick:function(){
                        controlLinea.getInteraction().finishDrawing();
                    }

                })
            ]
        })
    });
    barraDibujo.addControl(controlLinea);

    var controlPoligono =  new ol.control.Toggle({
        title:'Dibujar polígono',
        html:'<i class="fa fa-bookmark-o fa-rotate-270"></i>',
        interaction: new ol.interaction.Draw({
            type:'Polygon',
            source:this.vector.getSource()
        }),
        bar: new ol.control.Bar({
            controls:[
                new ol.control.TextButton({
                    title:'Deshacer ultimo punto',
                    html:'Deshacer',
                    handleClick:function(){
                        controlPoligono.getInteraction().removeLastPoint()
                    }
                }),
                new ol.control.TextButton({
                    title:'Finalizar dibujo',
                    html:'Finalizar',
                    handleClick:function(){
                        controlPoligono.getInteraction().finishDrawing();
                    }

                })
            ]
        })

    });
    barraDibujo.addControl(controlPoligono);

    var controlSelect = new ol.control.Toggle({
        title:'Seleccionar dibujo',
        html:'<i class="fa fa-hand-pointer-o"></i>',
        interaction : new ol.interaction.Select(),
        bar: new ol.control.Bar({
            controls:[
                new ol.control.TextButton({
                    title:'Eliminar dibujo',
                    html:'Eliminar',
                    handleClick: function(){
                        var features = controlSelect.getInteraction().getFeatures();
                        if(!features.getLength()) {alert('Debe seleccionar primero un dibujo.')}

                        for(var i=0,f;f = features.item(i); i++){
                            self.vector.getSource().removeFeature(f);
                            
                        }
                        controlSelect.getInteraction().getFeatures().clear();
                    }
                })
            ]
        })
    });
    barraDibujo.addControl(controlSelect);




}

GeoMap.prototype.CrearBarraBusquedaGeoJson = function(vectorLayerGeoJson) {
    var self = this;

    if (!this.mainBarCustom) {
        this.mainBarCustom = new ol.control.Bar();
        this.map.addControl(this.mainBarCustom);
        this.mainBarCustom.setPosition('top');
    }

    var select = new ol.interaction.Select({});
    this.map.addInteraction(select);

    if (vectorLayerGeoJson) {
        var controlBusqueda = new ol.control.SearchFeature({
            source: vectorLayerGeoJson,
            property: 'usuario'
        });
        this.map.addControl(controlBusqueda);

        controlBusqueda.on('select', function(e) {
            select.getFeatures().clear();
            select.getFeatures().push(e.search);
            var propiedades = e.search.getProperties();
            mostrarPropiedades(propiedades);
            var p = e.search.getGeometry().getFirstCoordinate();
            self.map.getView().animate({ center: p, zoom: 19 });
        });
    }
}



GeoMap.prototype.CrearEventoClicEnMapa = function() {
    var self = this;
    
    // Agregar un evento de clic al mapa
    this.map.on('click', function(event) {
        // Obtener las coordenadas del punto donde se hizo clic
        var coordinate = event.coordinate;
        
        // Convertir las coordenadas a la proyección del servidor (EPSG:4326)
        var lonLatCoordinate = ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');
        
        // Mostrar las coordenadas en la consola
        console.log('Coordenadas de clic:', lonLatCoordinate);
        
        // Realizar la solicitud al servidor para obtener información asociada a las coordenadas
        axios.get('http://localhost:8080/geoserver/datos4/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=datos4%3Adatos4&maxFeatures=50&outputFormat=application%2Fjson')
        .then(function(response) {
            // Obtener todas las entidades del JSON
            var features = response.data.features;
            
            // Buscar la entidad más cercana al punto de clic
            var closestFeature = null;
            var closestDistance = Infinity;
            features.forEach(function(feature) {
                var coordinates = feature.geometry.coordinates;
                var distance = Math.sqrt(Math.pow(coordinates[0] - lonLatCoordinate[0], 2) + Math.pow(coordinates[1] - lonLatCoordinate[1], 2));
                if (distance < closestDistance) {
                    closestFeature = feature;
                    closestDistance = distance;
                }
            });
            
            // Manejar la entidad más cercana
            if (closestFeature) {
                console.log('Información asociada al punto:', closestFeature);
            } else {
                console.log('No se encontró ninguna entidad cercana al punto de clic.');
            }
        })
        .catch(function(error) {
            // Manejar errores de la solicitud
            console.error('Error al obtener información:', error);
        });
    });
};



