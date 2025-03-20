#!/usr/bin/env python3
import csv
import re
import sys

def load_mapping(csv_file):
    """
    Carga el mapeo de colores desde un archivo CSV.
    Se espera que el CSV tenga las columnas:
    original_color,new_color,description,note
    """
    mapping = {}
    with open(csv_file, newline='', encoding='utf-8') as f:
        reader = csv.DictReader(f)
        for row in reader:
            # Normalizamos a minúsculas para hacer comparaciones insensibles
            orig = row['original_color'].strip().lower()
            new = row['new_color'].strip()
            mapping[orig] = new
    return mapping

def replace_colors(css_text, mapping):
    """
    Recorre el texto CSS y reemplaza las ocurrencias de cada color hexadecimal
    por su nuevo valor, usando lookarounds para asegurar coincidencias exactas
    sin depender de \b (que no funciona bien con caracteres como '#').
    """
    for orig, new in mapping.items():
        # El lookbehind (?<![0-9A-Fa-f]) y el lookahead (?![0-9A-Fa-f]) se aseguran
        # de que el código hex no esté incrustado en otra secuencia de hexadecimales.
        pattern = r'(?i)(?<![0-9A-Fa-f])' + re.escape(orig) + r'(?![0-9A-Fa-f])'
        css_text = re.sub(pattern, new, css_text)
    return css_text

def main():
    if len(sys.argv) != 4:
        print("Uso: {} archivo_original.css mapeo.csv archivo_modificado.css".format(sys.argv[0]))
        sys.exit(1)
    
    input_css = sys.argv[1]
    mapping_csv = sys.argv[2]
    output_css = sys.argv[3]

    # Leer el archivo CSS original
    with open(input_css, 'r', encoding='utf-8') as f:
        css_text = f.read()
    
    # Cargar el mapeo de colores desde el CSV
    mapping = load_mapping(mapping_csv)
    
    # Reemplazar todos los colores en el CSS según el mapeo
    new_css = replace_colors(css_text, mapping)

    # Guardar el CSS modificado
    with open(output_css, 'w', encoding='utf-8') as f:
        f.write(new_css)
    
    print("Colores reemplazados y archivo guardado en:", output_css)

if __name__ == '__main__':
    main()
