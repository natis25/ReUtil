package Sucursales;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import util.Database;

public class SucursalDAO {

    public static void insertar(Sucursal sucursal) throws SQLException {
        String sql = "INSERT INTO Sucursal (nombre_sucursal, telefono, direccion) VALUES (?, ?, ?)";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS)) {

            stmt.setString(1, sucursal.getNombreSucursal());
            stmt.setInt(2, sucursal.getTelefono());
            stmt.setString(3, sucursal.getDireccion());
            stmt.executeUpdate();

            try (ResultSet rs = stmt.getGeneratedKeys()) {
                if (rs.next()) {
                    sucursal.setIdSucursal(rs.getInt(1));
                }
            }
        }
    }

    public static List<Sucursal> listarTodos() throws SQLException {
        List<Sucursal> sucursales = new ArrayList<>();
        String sql = "SELECT * FROM Sucursal";
        try (Connection conn = Database.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {

            while (rs.next()) {
                Sucursal sucursal = new Sucursal(
                    rs.getString("nombre_sucursal"),
                    rs.getInt("telefono"),
                    rs.getString("direccion")
                );
                sucursal.setIdSucursal(rs.getInt("id_sucursal"));
                sucursales.add(sucursal);
            }
        }
        return sucursales;
    }

    public static void actualizar(Sucursal sucursal) throws SQLException {
        String sql = "UPDATE Sucursal SET nombre_sucursal = ?, telefono = ?, direccion = ? WHERE id_sucursal = ?";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setString(1, sucursal.getNombreSucursal());
            stmt.setInt(2, sucursal.getTelefono());
            stmt.setString(3, sucursal.getDireccion());
            stmt.setInt(4, sucursal.getIdSucursal());
            stmt.executeUpdate();
        }
    }

    public static void eliminar(int idSucursal) throws SQLException {
        String sql = "DELETE FROM Sucursal WHERE id_sucursal = ?";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setInt(1, idSucursal);
            stmt.executeUpdate();
        }
    }
}
