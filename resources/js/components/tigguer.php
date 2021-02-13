nombre del trigger => tr_updateStockIngreso
despues de haber insertado => AFTER INSERT ON
por cada fila que actualice ==>  FOR EACH ROW BEGIN


DELIMITER //
CREATE TRIGGER triggerUpdateStockIngreso AFTER INSERT ON detalle_ingresos
 FOR EACH ROW BEGIN
  UPDATE articulos SET articulos.stock = articulos.stock+NEW.cantidad
    WHERE articulos.id = NEW.idarticulo;
    END//
DELIMITER ;



//triguer para actualizar el stock de los articulos que anule la factura por medio del id del ingreso que quiero eliminar

DELIMITER //
CREATE TRIGGER triggerAnularStockIngreso AFTER UPDATE ON ingresos
  FOR EACH ROW BEGIN
  UPDATE articulos a
     JOIN detalle_ingresos di
         ON di.idarticulo=a.id
         AND di.idingreso=NEW.id
         SET a.stock=a.stock-di.cantidad;
    END//
DELIMITER ;



//triguer venta para actualizar los stock "se reste"

DELIMITER //
CREATE TRIGGER triggerUpdateStockVenta AFTER INSERT ON detalle_ventas
 FOR EACH ROW BEGIN
  UPDATE articulos SET articulos.stock = articulos.stock-NEW.cantidad
    WHERE articulos.id = NEW.id_articulo;
    END//

DELIMITER ;


//triguer para actualizar el stock de los articulos que anule la factura por medio del id del venta que quiero eliminar

DELIMITER //
CREATE TRIGGER triggerAnularStockVenta AFTER UPDATE ON ventas
  FOR EACH ROW BEGIN
  UPDATE articulos a
     JOIN detalle_ventas dv
         ON dv.id_articulo=a.id
         AND dv.id_venta=NEW.id
         SET a.stock=a.stock+dv.cantidad;
    END//
DELIMITER ;



//ajuste de inventario productos entran al inventario (+)
DELIMITER //
CREATE TRIGGER triggerUpdateStockAjusteEntra AFTER INSERT ON detalleajusteinventario
 FOR EACH ROW BEGIN
  UPDATE articulos SET articulos.stock = articulos.stock+NEW.cantidad_entran
    WHERE articulos.id = NEW.id_articulo;
    WHERE 'ENTRA' = NEW.tipo_ajuste;

    END//
DELIMITER ;


//ajuste de inventario productos SALE al inventario (-)
DELIMITER //
CREATE TRIGGER triggerUpdateStockAjusteSale AFTER INSERT ON detalleajusteinventario
 FOR EACH ROW BEGIN
  UPDATE articulos SET articulos.stock = articulos.stock-NEW.cantidad_entran
    WHERE articulos.id = NEW.id_articulo;
    WHERE 'SALE' = NEW.tipo_ajuste;
    END//
DELIMITER ;