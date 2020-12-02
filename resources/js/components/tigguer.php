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