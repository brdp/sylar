<?php
/*
 * This file is part of Sylar.
 *
 * Sylar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Sylar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Sylar.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @copyright Copyright Sylar Development Team
 * @license http://www.gnu.org/licenses/ GNU Public License V2.0
 * @see https://launchpad.net/sylar/
 * @see http://www.giano-solutions.com
 */

/**
 * Example Sylar File
 * Some files that shows how sylar works
 * 
 * @package Sylar
 * @version 1.0
 * @since 02-2008
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */

#
# Include the bas Application settings
#
require_once '../config/appConfig.php';



import('sylar.common.system.SylarUtils');



#
# TEST import an application Class
#
#import('app.db.mysql.driverApp");

?>

<html>
	<head>
		<title>Sylar Framework - Import</title>
	</head>
	<body> 
    
	<a href='01.php'>Test DB &raquo;</a><br><br>

    <textarea style='width: 100%; height: 500px;'>
<?php
		echo "\n\n\n-----------------------";
		echo "\nSylar included Files:\n";
		Sylar_SylarUtils::showIncludedFiles();		
		echo "\n\nSylar Defined Costants:\n";
		Sylar_SylarUtils::showDefinedCostant();
?>
</textarea>


	</body>
</html>

