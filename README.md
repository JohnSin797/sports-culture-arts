# Sports_Culture_Art 

accomplishment
    #login page done but not completely
    #home page not done but working on it 


# Run this on mysql
    #For auto update on stocks' total_quantity
    
***********************************************************************

DELIMITER $$

CREATE TRIGGER update_total_quantity_before_update
BEFORE UPDATE ON stocks
FOR EACH ROW
BEGIN
    IF NEW.equipment_id = OLD.equipment_id THEN
        SET NEW.total_quantity = NEW.stock + NEW.borrow + NEW.damaged;
    END IF;
END$$

DELIMITER ;

***********************************************************************

DELIMITER $$

CREATE TRIGGER update_total_quantity_before_insert
BEFORE INSERT ON stocks
FOR EACH ROW
BEGIN
    IF NEW.equipment_id IS NOT NULL THEN
        SET NEW.total_quantity = NEW.stock + NEW.borrow + NEW.damaged;
    END IF;
END$$

DELIMITER ;

***********************************************************************