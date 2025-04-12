package Tipo_dispositivos;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class Database {
    private static final String URL = "jdbc:mysql://localhost:3306/reeutil";
    private static final String USER = "root";  // Usuario de XAMPP
    private static final String PASSWORD = "";  // Contraseña de XAMPP
    
    public static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(URL, USER, PASSWORD);
    }

}