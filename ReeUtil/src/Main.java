import Tipo_dispositivos.TipoDispositivo;
import Tipo_dispositivos.TipoDispositivoDAO;
import Marcas.Marca;
import Marcas.MarcaDAO;
import Sucursales.Sucursal;
import Sucursales.SucursalDAO;

import java.sql.SQLException;
import java.util.List;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        while (true) {
            System.out.println("\n--- Menú Principal ---");
            System.out.println("1. ABM Tipo Dispositivo");
            System.out.println("2. ABM Marca");
            System.out.println("3. ABM Sucursal");
            System.out.println("4. Salir");
            System.out.print("Opción: ");
            int opcion = scanner.nextInt();
            scanner.nextLine(); // Limpiar buffer

            switch (opcion) {
                case 1 -> menuTipoDispositivo(scanner);
                case 2 -> menuMarca(scanner);
                case 3 -> menuSucursal(scanner);
                case 4 -> {
                    System.out.println("Saliendo...");
                    return;
                }
                default -> System.out.println("Opción inválida.");
            }
        }
    }

    // --- ABM TipoDispositivo ---
    private static void menuTipoDispositivo(Scanner scanner) {
        while (true) {
            System.out.println("\n--- ABM Tipo Dispositivo ---");
            System.out.println("1. Listar");
            System.out.println("2. Crear");
            System.out.println("3. Actualizar");
            System.out.println("4. Eliminar");
            System.out.println("5. Volver");
            System.out.print("Opción: ");
            int opcion = scanner.nextInt();
            scanner.nextLine();

            switch (opcion) {
                case 1 -> {
                    try {
                        List<TipoDispositivo> tipos = TipoDispositivoDAO.listarTodos();
                        for (TipoDispositivo tipo : tipos) {
                            System.out.printf("ID: %d | Nombre: %s | Aceptado: %s\n",
                                    tipo.getIdTipo(), tipo.getNombreTipo(), tipo.isAceptado() ? "Sí" : "No");
                        }
                    } catch (SQLException e) {
                        System.err.println("Error al listar: " + e.getMessage());
                    }
                }
                case 2 -> {
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
                case 3 -> {
                    System.out.print("ID del tipo a actualizar: ");
                    int id = scanner.nextInt();
                    scanner.nextLine();

                    try {
                        TipoDispositivo tipo = TipoDispositivoDAO.listarTodos().stream()
                                .filter(t -> t.getIdTipo() == id).findFirst().orElse(null);
                        if (tipo == null) {
                            System.out.println("❌ Tipo no encontrado.");
                            return;
                        }

                        System.out.print("Nuevo nombre (" + tipo.getNombreTipo() + "): ");
                        String nuevoNombre = scanner.nextLine();
                        if (!nuevoNombre.isEmpty()) tipo.setNombreTipo(nuevoNombre);

                        System.out.print("¿Aceptado? (" + tipo.isAceptado() + "): ");
                        if (scanner.hasNextBoolean()) tipo.setAceptado(scanner.nextBoolean());

                        TipoDispositivoDAO.actualizar(tipo);
                        System.out.println("✅ Tipo actualizado.");
                    } catch (SQLException e) {
                        System.err.println("Error al actualizar: " + e.getMessage());
                    }
                }
                case 4 -> {
                    System.out.print("ID del tipo a eliminar: ");
                    int id = scanner.nextInt();
                    try {
                        TipoDispositivoDAO.eliminar(id);
                        System.out.println("✅ Tipo eliminado.");
                    } catch (SQLException e) {
                        System.err.println("Error al eliminar: " + e.getMessage());
                    }
                }
                case 5 -> {
                    return;
                }
                default -> System.out.println("Opción inválida.");
            }
        }
    }

    // --- ABM Marca ---
    private static void menuMarca(Scanner scanner) {
        while (true) {
            System.out.println("\n--- ABM Marca ---");
            System.out.println("1. Listar");
            System.out.println("2. Crear");
            System.out.println("3. Actualizar");
            System.out.println("4. Eliminar");
            System.out.println("5. Volver");
            System.out.print("Opción: ");
            int opcion = scanner.nextInt();
            scanner.nextLine();

            switch (opcion) {
                case 1 -> {
                    try {
                        List<Marca> marcas = MarcaDAO.listarTodos();
                        for (Marca marca : marcas) {
                            System.out.printf("ID: %d | Marca: %s\n", marca.getIdMarca(), marca.getNombreMarca());
                        }
                    } catch (SQLException e) {
                        System.err.println("Error al listar: " + e.getMessage());
                    }
                }
                case 2 -> {
                    System.out.print("Nombre de la marca: ");
                    String nombre = scanner.nextLine();
                    Marca marca = new Marca(nombre);
                    try {
                        MarcaDAO.insertar(marca);
                        System.out.println("✅ Marca creada con ID: " + marca.getIdMarca());
                    } catch (SQLException e) {
                        System.err.println("Error al crear: " + e.getMessage());
                    }
                }
                case 3 -> {
                    System.out.print("ID de la marca a actualizar: ");
                    int id = scanner.nextInt();
                    scanner.nextLine();

                    try {
                        Marca marca = MarcaDAO.listarTodos().stream()
                                .filter(m -> m.getIdMarca() == id).findFirst().orElse(null);
                        if (marca == null) {
                            System.out.println("❌ Marca no encontrada.");
                            return;
                        }

                        System.out.print("Nuevo nombre (" + marca.getNombreMarca() + "): ");
                        String nuevoNombre = scanner.nextLine();
                        if (!nuevoNombre.isEmpty()) marca.setNombreMarca(nuevoNombre);

                        MarcaDAO.actualizar(marca);
                        System.out.println("✅ Marca actualizada.");
                    } catch (SQLException e) {
                        System.err.println("Error al actualizar: " + e.getMessage());
                    }
                }
                case 4 -> {
                    System.out.print("ID de la marca a eliminar: ");
                    int id = scanner.nextInt();
                    try {
                        MarcaDAO.eliminar(id);
                        System.out.println("✅ Marca eliminada.");
                    } catch (SQLException e) {
                        System.err.println("Error al eliminar: " + e.getMessage());
                    }
                }
                case 5 -> {
                    return;
                }
                default -> System.out.println("Opción inválida.");
            }
        }
    }

    // --- ABM Sucursal ---
    private static void menuSucursal(Scanner scanner) {
        while (true) {
            System.out.println("\n--- ABM Sucursal ---");
            System.out.println("1. Listar");
            System.out.println("2. Crear");
            System.out.println("3. Actualizar");
            System.out.println("4. Eliminar");
            System.out.println("5. Volver");
            System.out.print("Opción: ");
            int opcion = scanner.nextInt();
            scanner.nextLine();

            switch (opcion) {
                case 1 -> {
                    try {
                        List<Sucursal> sucursales = SucursalDAO.listarTodos();
                        for (Sucursal s : sucursales) {
                            System.out.printf("ID: %d | Nombre: %s | Teléfono: %d | Dirección: %s\n",
                                    s.getIdSucursal(), s.getNombreSucursal(), s.getTelefono(), s.getDireccion());
                        }
                    } catch (SQLException e) {
                        System.err.println("Error al listar: " + e.getMessage());
                    }
                }
                case 2 -> {
                    System.out.print("Nombre de la sucursal: ");
                    String nombre = scanner.nextLine();
                    System.out.print("Teléfono: ");
                    int telefono = scanner.nextInt();
                    scanner.nextLine();
                    System.out.print("Dirección: ");
                    String direccion = scanner.nextLine();

                    Sucursal sucursal = new Sucursal(nombre, telefono, direccion);
                    try {
                        SucursalDAO.insertar(sucursal);
                        System.out.println("✅ Sucursal creada con ID: " + sucursal.getIdSucursal());
                    } catch (SQLException e) {
                        System.err.println("Error al crear: " + e.getMessage());
                    }
                }
                case 3 -> {
                    System.out.print("ID de la sucursal a actualizar: ");
                    int id = scanner.nextInt();
                    scanner.nextLine();

                    try {
                        Sucursal sucursal = SucursalDAO.listarTodos().stream()
                                .filter(s -> s.getIdSucursal() == id).findFirst().orElse(null);
                        if (sucursal == null) {
                            System.out.println("❌ Sucursal no encontrada.");
                            return;
                        }

                        System.out.print("Nuevo nombre (" + sucursal.getNombreSucursal() + "): ");
                        String nuevoNombre = scanner.nextLine();
                        if (!nuevoNombre.isEmpty()) sucursal.setNombreSucursal(nuevoNombre);

                        System.out.print("Nuevo teléfono (" + sucursal.getTelefono() + "): ");
                        if (scanner.hasNextInt()) sucursal.setTelefono(scanner.nextInt());
                        scanner.nextLine();

                        System.out.print("Nueva dirección (" + sucursal.getDireccion() + "): ");
                        String nuevaDireccion = scanner.nextLine();
                        if (!nuevaDireccion.isEmpty()) sucursal.setDireccion(nuevaDireccion);

                        SucursalDAO.actualizar(sucursal);
                        System.out.println("✅ Sucursal actualizada.");
                    } catch (SQLException e) {
                        System.err.println("Error al actualizar: " + e.getMessage());
                    }
                }
                case 4 -> {
                    System.out.print("ID de la sucursal a eliminar: ");
                    int id = scanner.nextInt();
                    try {
                        SucursalDAO.eliminar(id);
                        System.out.println("✅ Sucursal eliminada.");
                    } catch (SQLException e) {
                        System.err.println("Error al eliminar: " + e.getMessage());
                    }
                }
                case 5 -> {
                    return;
                }
                default -> System.out.println("Opción inválida.");
            }
        }
    }
}
