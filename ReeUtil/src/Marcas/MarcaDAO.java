package Marcas;

import util.Database;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class MarcaDAO {

    public static void insertar(Marca marca) throws SQLException {
        String sql = "INSERT INTO Marca (marca) VALUES (?)";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS)) {
            stmt.setString(1, marca.getMarca());
            stmt.executeUpdate();

            try (ResultSet rs = stmt.getGeneratedKeys()) {
                if (rs.next()) {
                    marca.setIdMarca(rs.getInt(1));
                }
            }
        }
    }

    public static List<Marca> listarTodas() throws SQLException {
        List<Marca> marcas = new ArrayList<>();
        String sql = "SELECT * FROM Marca";
        try (Connection conn = Database.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Marca marca = new Marca(rs.getString("marca"));
                marca.setIdMarca(rs.getInt("id_marca"));
                marcas.add(marca);
            }
        }
        return marcas;
    }

    public static void actualizar(Marca marca) throws SQLException {
        String sql = "UPDATE Marca SET marca = ? WHERE id_marca = ?";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, marca.getMarca());
            stmt.setInt(2, marca.getIdMarca());
            stmt.executeUpdate();
        }
    }

    public static void eliminar(int idMarca) throws SQLException {
        String sql = "DELETE FROM Marca WHERE id_marca = ?";
        try (Connection conn = Database.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, idMarca);
            stmt.executeUpdate();
        }
    }
}
