<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Xml {

    public function crearXml($clave, $fecha, $data) {

        switch ($data['tipo']) {
            case 1:
                $xmlString = '<?xml version="1.0" encoding="utf-8"?>
        <FacturaElectronica xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="https://tribunet.hacienda.go.cr/docs/esquemas/2017/v4.2/facturaElectronica" xsi:schemaLocation="https://tribunet.hacienda.go.cr/docs/esquemas/2017/v4.2/facturaElectronica https://tribunet.hacienda.go.cr/docs/esquemas/2017/v4.2/facturaElectronica.xsd">';
                break;
            case 2:
                $xmlString = '<?xml version="1.0" encoding="utf-8"?>
        <NotaDebitoElectronica xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/notaDebitoElectronica" xsi:schemaLocation="https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/notaDebitoElectronica https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/notaDebitoElectronica.xsd">';
                break;
            case 3:
                $xmlString = '<?xml version="1.0" encoding="utf-8"?>
        <NotaCreditoElectronica xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/notaCreditoElectronica" xsi:schemaLocation="https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/notaCreditoElectronica https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/notaCreditoElectronica.xsd">';
                break;
            case 4:
                $xmlString = '<?xml version="1.0" encoding="utf-8"?>
        <TiqueteElectronico xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/tiqueteElectronico" xsi:schemaLocation="https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/tiqueteElectronico https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/tiqueteElectronico.xsd">';
                break;
        }
        $xmlString .= '
        <Clave>' . $clave . '</Clave>
        <NumeroConsecutivo>' . $data['consecutivo'] . '</NumeroConsecutivo>
        <FechaEmision>' . $fecha . '</FechaEmision>
        <Emisor><Nombre>' . $data['emisor']['nombre'] . '</Nombre>
        <Identificacion>
        <Tipo>' . $data['emisor']['tipoidentificacion'] . '</Tipo>
        <Numero>' . $data['emisor']['numeroIdentificacion'] . '</Numero>
        </Identificacion>
        <Ubicacion>
        <Provincia>' . $data['emisor']['provincia'] . '</Provincia>
        <Canton>' . $data['emisor']['canton'] . '</Canton>
        <Distrito>' . $data['emisor']['distrito'] . '</Distrito>
        <OtrasSenas>' . $data['emisor']['OtrasSenas'] . '</OtrasSenas>
        </Ubicacion>
        <Telefono>
        <CodigoPais>' . $data['emisor']['codigopaistelefono'] . '</CodigoPais>
        <NumTelefono>' . $data['emisor']['telefono'] . '</NumTelefono>
        </Telefono>
        <CorreoElectronico>' . $data['emisor']['correo'] . '</CorreoElectronico>
        </Emisor>
        <Receptor>
        <Nombre>' . $data['receptor']['nombre'] . '</Nombre>
        <Identificacion>
        <Tipo>' . $data['receptor']['tipoidentificacion'] . '</Tipo>
        <Numero>' . $data['receptor']['numeroIdentificacion'] . '</Numero>
        </Identificacion>
        <NombreComercial/>
        <Ubicacion>
        <Provincia>' . $data['receptor']['provincia'] . '</Provincia>
        <Canton>' . $data['receptor']['canton'] . '</Canton>
        <Distrito>' . $data['receptor']['distrito'] . '</Distrito>
        <Barrio>' . $data['receptor']['barrio'] . '</Barrio>
        <OtrasSenas>' . $data['receptor']['OtrasSenas'] . '</OtrasSenas>
        </Ubicacion>
        <Telefono>
        <CodigoPais>' . $data['receptor']['codigopaistelefono'] . '</CodigoPais>
        <NumTelefono>' . $data['receptor']['telefono'] . '</NumTelefono>
        </Telefono>
        <CorreoElectronico>' . $data['receptor']['correo'] . '</CorreoElectronico>
        </Receptor>
        <CondicionVenta>' . $data['CondicionVenta'] . '</CondicionVenta>
        <MedioPago>' . $data['MedioPago'] . '</MedioPago>
        <DetalleServicio>';
        $count = 1;
        foreach ($data['detalles'] as $detalle) {
            $xmlString .= '<LineaDetalle><NumeroLinea>' . $count . '</NumeroLinea>
            <Codigo>
                <Tipo>' . $detalle['codigotipo'] . '</Tipo>
                <Codigo>' . $detalle['codigodescripcion'] . '</Codigo>
            </Codigo>
            <Cantidad>' . $detalle['cantidad'] . '</Cantidad>
            <UnidadMedida>' . $detalle['unidad'] . '</UnidadMedida>
            <Detalle>' . utf8_encode($detalle['detalle']) . '</Detalle>
            <PrecioUnitario>' . $detalle['preciounitario'] . '</PrecioUnitario>
            <MontoTotal>' . $detalle['montototal'] . '</MontoTotal>';
            if ($detalle['montodescuento'] > 0) {
                $xmlString .= '<MontoDescuento>' . $detalle['montodescuento'] . '</MontoDescuento>
                 <NaturalezaDescuento>' . $detalle['descripciondescuento'] . '</NaturalezaDescuento>';
            }

            $xmlString .= '<SubTotal>' . $detalle['subtotal'] . '</SubTotal>';
            if ($detalle['montodescuento'] > 0) {
                $xmlString .= '<Impuesto>
             <Codigo>' . $detalle['codigoimpuesto'] . '</Codigo>
             <Tarifa>' . $detalle['tarifaimpuesto'] . '</Tarifa>
             <Monto>' . $detalle['montoimpuesto'] . '</Monto>
             </Impuesto>';
            }

            $xmlString .= '<MontoTotalLinea>' . $detalle['totallinea'] . '</MontoTotalLinea>
             </LineaDetalle>';
            $count++;
        }

        $xmlString .= '</DetalleServicio>
        <ResumenFactura>
        <CodigoMoneda>' . $data['codigomoneda'] . '</CodigoMoneda>
        <TotalServGravados>' . $data['totalservgravados'] . '</TotalServGravados>
        <TotalServExentos>' . $data['totalservexentos'] . '</TotalServExentos>
        <TotalMercanciasGravadas>' . $data['totalmercanciasgravadas'] . '</TotalMercanciasGravadas>
        <TotalMercanciasExentas>' . $data['totalmercanciasexentas'] . '</TotalMercanciasExentas>
        <TotalGravado>' . $data['totalgravado'] . '</TotalGravado>
        <TotalExento>' . $data['totalexento'] . '</TotalExento>
        <TotalVenta>' . $data['totalventa'] . '</TotalVenta>
        <TotalDescuentos>' . $data['totaldescuentos'] . '</TotalDescuentos>
        <TotalVentaNeta>' . $data['totalventaneta'] . '</TotalVentaNeta>
        <TotalImpuesto>' . $data['totalImpuesto'] . '</TotalImpuesto>
        <TotalComprobante>' . $data['totalcomprobante'] . '</TotalComprobante>
        </ResumenFactura>

        <Normativa>
        <NumeroResolucion>DGT-R-48-2016</NumeroResolucion>
        <FechaResolucion>07-10-2016 00:00:00</FechaResolucion>
        </Normativa>
        <Otros><OtroTexto>' . $data['referencia'] . '</OtroTexto></Otros>';
        switch ($data['tipo']) {
            case 1:
                $xmlString .= '</FacturaElectronica>';
                break;
            case 2:
                $xmlString .= '</NotaDebitoElectronica>';
                break;
            case 3:
                $xmlString .= '</NotaCreditoElectronica>';
                break;
            case 4:
                $xmlString .= '</TiqueteElectronico>';
                break;
        }
        $dom = new DomDocument();
        $dom->preseveWhiteSpace = false;
        $dom->loadXML($xmlString);

        $dom->save('assets/xml/' . $clave . '.xml');
        return 'assets/xml/' . $clave . '.xml';
    }

}
