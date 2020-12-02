nombre del trigger => tr_updateStockIngreso
despues de haber insertado => AFTER INSERT ON
por cada fila que actualice ==>  FOR EACH ROW BEGIN

DELIMITER //
CREATE TRIGGER triggerUpdateStockIngreso AFTER INSERT ON detalle_ingresos
 FOR EACH ROW BEGIN 
  UPDATE articulos SET articulos.stock = articulos.stock+NEXT.cantidad
    WHERE articulos.id = NEXT.idarticulo;
    END//

DELIMITER ;

 

DELIMITER //
CREATE TRIGGER triggerUpdateStockIngreso AFTER INSERT ON detalle_ingresos
 FOR EACH ROW BEGIN 
  UPDATE articulos SET articulos.stock = articulos.stock+NEW.cantidad
    WHERE articulos.id = NEW.idarticulo;
    END//

DELIMITER ;