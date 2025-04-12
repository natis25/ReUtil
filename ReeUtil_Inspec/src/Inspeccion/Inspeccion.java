package Inspeccion;

import java.util.*;

public class Inspeccion {
    private static final Map<String, List<String>> criteriosPorTipo = new HashMap<>();

    static {
        criteriosPorTipo.put("laptop", Arrays.asList(
            "¿Enciende correctamente?",
            "¿Pantalla en buen estado?",
            "¿Bateria funcional?",
            "¿Cargador incluido?"
        ));
        criteriosPorTipo.put("celular", Arrays.asList(
            "¿Pantalla sin grietas?",
            "¿Carga correctamente?",
            "¿Botones funcionales?",
            "¿Liberado de cuenta?"
        ));
        criteriosPorTipo.put("tablet", Arrays.asList(
            "¿Pantalla tactil funcional?",
            "¿Bateria aceptable?",
            "¿Sin daños externos?",
            "¿Lapiz funcional?",
            "¿Cargador incluido?"
        ));
    }

    public static void main(String[] args) {
    	// Dispositivo de ejemplo
        String idDispositivo = "00123";
        String nombreDispositivo = "Laptop Acer Aspire";

        System.out.println("Diagnostico de Dispositivo");
        System.out.println("ID: " + idDispositivo);
        System.out.println("Nombre: " + nombreDispositivo);

        // Pedir al usuario seleccionar el tipo de dispositivo
        Scanner scanner = new Scanner(System.in);
        System.out.println("\nSelecciona el tipo de dispositivo:");
        System.out.println("1. Laptop\n2. Celular\n3. Tablet");
        int tipoSeleccionado = scanner.nextInt();
        scanner.nextLine(); // Limpiar el buffer

        String tipoDispositivo = "";

        switch (tipoSeleccionado) {
            case 1:
                tipoDispositivo = "laptop";
                break;
            case 2:
                tipoDispositivo = "celular";
                break;
            case 3:
                tipoDispositivo = "tablet";
                break;
            default:
                System.out.println("Opcion no valida.");
                return;
        }

        // Mostrar los criterios según el tipo de dispositivo
        System.out.println("\nCriterios para evaluar el " + tipoDispositivo + ":");
        List<String> criterios = criteriosPorTipo.get(tipoDispositivo);

        // Mostrar los criterios y pedir respuestas
        List<String> respuestas = new ArrayList<>();
        for (String criterio : criterios) {
            System.out.println(criterio);
            System.out.print("¿Cumple con este criterio? (s/n): ");
            String respuesta = scanner.nextLine();
            respuestas.add(respuesta.toLowerCase());
        }

        // Cuantificar los resultados de la evaluacion
        int criteriosMarcados = (int) respuestas.stream().filter(respuesta -> respuesta.equals("s")).count();

        System.out.println("\nEvaluación completa:");
        System.out.println("Criterios marcados: " + criteriosMarcados);
        for (int i = 0; i < criterios.size(); i++) {
            if (respuestas.get(i).equals("s")) {
                System.out.println("+" + criterios.get(i));
            } else {
                System.out.println("-" + criterios.get(i));
            }
        }

        scanner.close();
    }
}
