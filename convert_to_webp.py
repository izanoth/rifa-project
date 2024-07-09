from PIL import Image
import os

def convert_png_to_webp(input_path, output_path):
    try:
        # Abre a imagem PNG
        img = Image.open(input_path)
        
        # Define as opções de compressão e salva como WebP
        img.save(output_path, 'webp', quality=80)
        print(f"Conversão concluída: {input_path} -> {output_path}")
    except Exception as e:
        print(f"Erro ao converter {input_path} para WebP: {e}")

def process_folder(folder_path):
    try:
        # Varre todos os arquivos e subpastas na pasta
        for root, dirs, files in os.walk(folder_path):
            for file in files:
                # Verifica se o arquivo é um PNG
                if file.lower().endswith('.png'):
                    input_path = os.path.join(root, file)
                    # Constrói o caminho de saída com a mesma estrutura
                    relative_path = os.path.relpath(input_path, folder_path)
                    output_path = os.path.join(output_folder, relative_path[:-4] + '.webp')
                    
                    # Cria subpastas se necessário
                    os.makedirs(os.path.dirname(output_path), exist_ok=True)

                    # Converte PNG para WebP
                    convert_png_to_webp(input_path, output_path)
    except Exception as e:
        print(f"Erro ao processar a pasta: {e}")

# Caminho da pasta de entrada (contendo os arquivos PNG)
input_folder = "."
# Caminho da pasta de saída (onde os arquivos WebP serão salvos)
output_folder = "webp/"

# Garante que a pasta de saída existe
os.makedirs(output_folder, exist_ok=True)

# Processa a pasta e suas subpastas
process_folder(input_folder)
