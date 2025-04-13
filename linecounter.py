import os

def count_specific_lines(folder_path, extensions, exclude_folders):
    """
    Belirtilen klasörde ve alt klasörlerdeki sadece belirtilen uzantılardaki dosyaların toplam satır sayısını bulur.

    Args:
        folder_path (str): Ana klasör yolu.
        extensions (tuple): Hesaplanacak dosya uzantıları (örneğin: .php, .css, .js).
        exclude_folders (list): İşleme dahil edilmeyecek klasörlerin adları.

    Returns:
        int: Toplam satır sayısı.
    """
    total_lines = 0
    total_files = 0

    for root, dirs, files in os.walk(folder_path):
        # Hariç tutulacak klasörleri çıkar
        dirs[:] = [d for d in dirs if d not in exclude_folders]

        for file in files:
            if file.endswith(extensions):  # Sadece belirtilen uzantılardaki dosyaları işleme al
                total_files += 1
                file_path = os.path.join(root, file)

                try:
                    with open(file_path, 'r', encoding='utf-8') as f:
                        lines = f.readlines()
                        total_lines += len(lines)
                except UnicodeDecodeError:
                    try:
                        with open(file_path, 'r', encoding='latin-1') as f:
                            lines = f.readlines()
                            total_lines += len(lines)
                    except Exception as e:
                        print(f"Hata: {file_path} dosyası okunamadı: {e}")
                except Exception as e:
                    print(f"Hata: {file_path} dosyası okunamadı: {e}")

    return total_lines, total_files

# Kullanım
folder_path = os.getcwd()  # Mevcut çalışma klasörü
extensions = (".php", ".css", ".js")  # Belirtilen uzantılar
exclude_folders = ["vendor"]  # Hariç tutulacak klasörler

total_lines, total_files = count_specific_lines(folder_path, extensions, exclude_folders)

print(f"İşlenen toplam dosya sayısı: {total_files}")
print(f"Toplam satır sayısı (sadece .php, .css, .js): {total_lines}")
