package Tipo_dispositivos;


import java.sql.SQLException;
import java.util.InputMismatchException;
import java.util.List;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        while (true) {
            System.out.println("\n--- ABM Tipo Dispositivo ---");
            System.out.println("1. Listar");
            System.out.println("2. Crear");
            System.out.println("3. Actualizar");
            System.out.println("4. Eliminar");
            System.out.println("5. Salir");
            System.out.print("Opción: ");

            int opcion = scanner.nextInt();
            scanner.nextLine();  // Limpiar buffer

            switch (opcion) {
                case 1 -> listarTipos();
                case 2 -> crearTipo(scanner);
                case 3 -> actualizarTipo(scanner);
                case 4 -> eliminarTipo(scanner);
                case 5 -> {
                    System.out.println("Saliendo...");
                    System.exit(0);
                }
                default -> System.out.println("Opción inválida.");
            }
        }
    }

    private static void listarTipos() {
        try {
            List<TipoDispositivo> tipos = TipoDispositivoDAO.listarTodos();
            for (TipoDispositivo tipo : tipos) {
                System.out.printf(
                    "ID: %d | Nombre: %s | Aceptado: %s\n",
                    tipo.getIdTipo(),
                    tipo.getNombreTipo(),
                    tipo.isAceptado() ? "Sí" : "No"
                );
            }
        } catch (SQLException e) {
            System.err.println("Error al listar: " + e.getMessage());
        }
    }

    private static void crearTipo(Scanner scanner) {
        System.out.print("Nombre del tipo: ");
        String nombre = scanner.nextLine();
        System.out.print("¿Aceptado? (true/false): ");
        boolean aceptado = scanner.nextBoolean();

        TipoDispositivo tipo = new TipoDispositivo(nombre, aceptado);
        try {
            TipoDispositivoDAO.insertar(tipo);
            System.out.println("✅ Tipo creado con ID: " + tipo.getIdTipo());
        } catch (SQLException e) {
            System.err.println("Error al crear: " + e.getMessage());
        }
    }

    private static void actualizarTipo(Scanner scanner) {
        System.out.print("ID del tipo a actualizar: ");
        int id = scanner.nextInt();
        scanner.nextLine();  // Limpiar buffer

        try {
            TipoDispositivo tipo = TipoDispositivoDAO.listarTodos().stream()
                .filter(t -> t.getIdTipo() == id)
                .findFirst()
                .orElse(null);

            if (tipo == null) {
                System.out.println("❌ Tipo no encontrado.");
                return;
            }

            System.out.print("Nuevo nombre (" + tipo.getNombreTipo() + "): ");
            String nuevoNombre = scanner.nextLine();
            if (!nuevoNombre.isEmpty()) {
                tipo.setNombreTipo(nuevoNombre);
            }

            System.out.print("¿Aceptado? (" + tipo.isAceptado() + "): ");
            if (scanner.hasNextBoolean()) {
                tipo.setAceptado(scanner.nextBoolean());
            }

            TipoDispositivoDAO.actualizar(tipo);
            System.out.println("✅ Tipo actualizado.");
        } catch (SQLException e) {
            System.err.println("Error al actualizar: " + e.getMessage());
        }
    }

    private static void eliminarTipo(Scanner scanner) {
        System.out.print("Ingrese el ID del tipo a eliminar: ");

        try {
            int id = scanner.nextInt();
            TipoDispositivoDAO.eliminar(id);
            System.out.println("✅ Tipo eliminado correctamente.");
            
        } catch (SQLException e) {
            System.err.println("❌ Error al eliminar: " + e.getMessage());
        }
    }

}
