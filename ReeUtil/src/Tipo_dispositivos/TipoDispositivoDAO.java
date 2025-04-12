package Tipo_dispositivos;

import util.Database;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class TipoDispositivoDAO {
    public static void insertar(TipoDispositivo tipo) throws SQLException {
        String sql = "INSERT INTO Tipo_dispositivo (nombre_tipo, aceptado) VALUES (?, ?)";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS)) {
            stmt.setString(1, tipo.getNombreTipo());
            stmt.setBoolean(2, tipo.isAceptado());
            stmt.executeUpdate();

            try (ResultSet rs = stmt.getGeneratedKeys()) {
                if (rs.next()) {
                    tipo.setIdTipo(rs.getInt(1));
                }
            }
        }
    }

    public static List<TipoDispositivo> listarTodos() throws SQLException {
        List<TipoDispositivo> tipos = new ArrayList<>();
        String sql = "SELECT * FROM Tipo_dispositivo";
        try (Connection conn = Database.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                TipoDispositivo tipo = new TipoDispositivo(
                    rs.getString("nombre_tipo"),
                    rs.getBoolean("aceptado")
                );
                tipo.setIdTipo(rs.getInt("id_tipo"));
                tipos.add(tipo);
            }
        }
        return tipos;
    }

    public static void actualizar(TipoDispositivo tipo) throws SQLException {
        String sql = "UPDATE Tipo_dispositivo SET nombre_tipo = ?, aceptado = ? WHERE id_tipo = ?";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, tipo.getNombreTipo());
            stmt.setBoolean(2, tipo.isAceptado());
            stmt.setInt(3, tipo.getIdTipo());
            stmt.executeUpdate();
        }
    }

    public static void eliminar(int idTipo) throws SQLException {
        String sql = "DELETE FROM Tipo_dispositivo WHERE id_tipo = ?";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, idTipo);
            stmt.executeUpdate();
        }
    }
}
