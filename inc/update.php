<?php


// en base de datos:

cambiar nombre de columna pky por element_id en tabla elements
// DROP TRIGGER IF EXISTS `createStructure3`;CREATE DEFINER=`root`@`localhost` TRIGGER `createStructure3` AFTER INSERT ON `elements` FOR EACH ROW BEGIN IF (NEW.stc != 0) THEN INSERT INTO elementparent (ppk, epk) VALUES ( (SELECT pky FROM elements WHERE upk = NEW.upk AND stc = 0), NEW.element_id ); END IF; IF (NEW.stc IS NULL AND NEW.bse != NEW.element_id) THEN INSERT INTO elementparent (ppk, epk) VALUES (NEW.bse, NEW.element_id); END IF; END
