<?php
/**
 * Here is the file to configure every parameters
 * of the Altis Life Admin Panel like
 * the database connection ...
 */

class Init
{
    /* DATABASE */
    const _DB_DSN = '127.0.0.1';                   		// Address of database, Can be 'localhost'
    const _DB_NME = 'arma3life';                        // The name of your table
    const _DB_USR = 'user';                         	// Database user
    const _DB_PWD = 'password';                         // Password of database user

   /* ALTIS LIFE */
    const _AT_COP_0 = 'Civil';                          // Grade name cop level 0
    const _AT_COP_1 = 'Recrue';                         // Grade name cop level 1
    const _AT_COP_2 = 'Sergent';                        // Grade name cop level 2
    const _AT_COP_3 = 'Adjudant';                       // Grade name cop level 3
    const _AT_COP_4 = 'Major';                          // Grade name cop level 4
    const _AT_COP_5 = 'Lieutenant';                     // Grade name cop level 5
    const _AT_COP_6 = 'Capitaine';                      // Grade name cop level 6
    const _AT_COP_7 = 'Chef';                           // Grade name cop level 7
    // Add more if you have more than 7 levels, check "tpl.php" ("at_cop" object) and "player.html" for TPL engine Twig

    /* SLIM */
    const _SLIM_ERR = true;                             // Hide or display errors (prod value = false)

    /* TWIG */
    const _TWIG_CHE = false;                            // Set to 'private/cache/' to active cache for twig (tpl engine) - not working here, cf /private/tpl.php #17
}
