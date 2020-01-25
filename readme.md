#generate entities from db
php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity

https://symfony.com/doc/current/doctrine/reverse_engineering.html

#Doctrine y las relaciones:

https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/association-mapping.html
	
#composer require urls
https://jmsyst.com/bundles/JMSSerializerBundle
https://packagist.org/packages/gedmo/doctrine-extensions
https://symfony.com/doc/master/bundles/FOSRestBundle/1-setting_up_the_bundle.html (fos/restbundle)
or
https://packagist.org/packages/friendsofsymfony/rest-bundle


#design patterms
https://www.journaldev.com/16813/dao-design-pattern
https://en.wikipedia.org/wiki/Mediator_pattern

#Comando
php bin/console debug:router
php bin/console doctrine:schema:update --dump-sql
php bin/console doctrine:schema:update --force


#Cosa que toqué-> Archivo fos_rest. Agregué esto.

fos_rest:
  routing_loader:
    default_format: json
    include_format: false
  param_fetcher_listener: force
  body_listener: true
  body_converter:
    enabled: true
  view:
    view_response_listener: true
    
#Solución al error de 'em'
https://stackoverflow.com/questions/11605530/symfony2-1-the-option-em-does-not-exist-when-using-datatransformer

#Calculo de prima, premio, descuentos
http://www.softeam.com.ar/manual/Temas_especiales2/Conceptos_basicos_sobre_Seguros.htm

#comando por error al momento de mapear relacion one to many (hijos-poliza, cuotas-poliza). Error estaba en el mappedBy("nro_poliza"). Era mappedBy("poliza")

php bin/console doctrine:schema:validate

#Fechas PHP
https://www.php.net/manual/es/datetime.examples-arithmetic.php

#QueryBuilder
https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/query-builder.html
