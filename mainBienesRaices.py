#!/usr/bin/env python
# coding: utf-8

# In[9]:


#aca van todas las importaciones 
# from selenium import webdriver
# from selenium.webdriver.chrome.options import Options
# from selenium.webdriver.common.by import By
# from selenium.webdriver.support.ui import WebDriverWait
# from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
import time
import sys

#sql
get_ipython().system('pip install mysql-connector-python')
import mysql.connector

#para fechas
from datetime import date

import requests


# clasificacion de precios
import numpy as np
from sklearn.ensemble import RandomForestClassifier
from datetime import date
import pandas as pd


# In[2]:


#esto de aca para hacer scraping con contenido dinamico js 
# chrome_options = Options()
# chrome_options.add_argument("--headless")
# chrome_options.add_argument("--no-sandbox")
# chrome_options.add_argument("--disable-dev-shm-usage")
# chrome_options.add_argument("--window-size=1920,1080")
# chrome_options.add_argument("--disable-gpu")
# chrome_options.add_argument("--log-level=3") 

# driver = None
headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"}

#arreglo inicial
results = []

#scraping
try:
    #esto para selenium sitios con contenido dinamico js jaiba script
    # driver = webdriver.Chrome(options=chrome_options)

    #diccionario de urls
    url_bases = {
        # 1: "https://portal.fsv.gob.sv/mapa-vivienda-nueva/?page={}",
        2: "https://www.encuentra24.com/el-salvador-es/bienes-raices-venta-de-propiedades?page={}",
        3: "https://remax-central.com.sv?page={}",
    }

    #conexion con mysql
    conn = mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='proyecto-machine',
    )
    cursor = conn.cursor()


    # Itera sobre cada URL base
    for id_url, base_url in url_bases.items():        
        # Iteración de páginas (de 1 a 5)
        for page in range(1, 6):
            url = base_url.format(page)
            # driver.get(url)

            #logica para cada sitio
            # if id_url == 1: # portal.fsv.gob.sv (Sitio Dinámico: REQUIERE JS)
            #     try:
            #         WebDriverWait(driver, 15).until(
            #             EC.presence_of_element_located((By.CLASS_NAME, "wpgmza_marker_list_class"))
            #         )
            #         time.sleep(2) 

            #         # Obtener el HTML procesado por JavaScript
            #         html_cargado = driver.page_source
            #         soup = BeautifulSoup(html_cargado, 'html.parser')

            #         # Selector de los elementos
            #         cards = soup.select(".wpgmaps_mlist_row")

            #         if not cards:
            #             break

            #         for c in cards:
            #             title_tag = c.select_one("p.wpgmza_marker_title a")
            #             title = title_tag.get_text(strip=True) if title_tag else None
            #             desc_div = c.select_one(".wpgmza-desc")
            #             description = desc_div.get_text(separator=' ', strip=True)
            #             price_tag = desc_div.select_one("strong")
            #             price = price_tag.get_text(strip=True) if price_tag else None
            #             #esta no tiene tipo de propiedad asi que se va como none
            #             property_type_id = 1
            #             #para la ubicacion el mismo titulo es la ubicacion, asi que se consulta a la base por la ubicacion, si la encuantra le pone dicho id o sino se crea
            #             location_tag = c.select_one("p.wpgmza_marker_title")
            #             location = location_tag.get_text(strip=True) if location_tag else None
            #             cursor.execute("SELECT id FROM locations WHERE location LIKE %s", (location,))

            #             query_result = cursor.fetchone()
            #             if query_result:
            #                 location_id = query_result[0]
            #             else:
            #                 #si no encuentra la ubicacion se crea
            #                 cursor.execute("INSERT INTO locations (location) VALUES (%s)", (location,))
            #                 location_id = cursor.lastrowid
            #                 conn.commit()
            #             #bedrooms como no tiene lo ponemos default a 1 lo mismo con bathrooms
            #             bedrooms = 1
            #             bathrooms = 1
            #             #area como no trae va por defecto unos 25 m2
            #             area = '25 m²'
            #             #como no trae fecha publicacion le pondremos fecha de scraping
            #             now = date.today()
            #             published_at = now.strftime('%Y-%m-%d')
            #             image = c.select_one(".wpgmza_map_image")
            #             image_url = image["src"] if image and image.get("src") else None
            #             source = url


            #             #añadimos los datos al arreglo
            #             results.append({
            #                 'title' : title,
            #                 'description' : description,
            #                 'price' : price,
            #                 'property_type_id' : property_type_id,
            #                 'location_id' : location_id,
            #                 'bedrooms' : bedrooms,
            #                 'bathrooms' : bathrooms,
            #                 'area' : area,
            #                 'published_at' : published_at,
            #                 'image_url' : image_url,
            #                 'source' : source
            #             })



            #     except Exception as e:
            #         print(f"Fallo en la extracción de FSV en página {page}: {e}")
            #         break 

            if id_url == 2: # encuentra24.com aca se seguiria con mas urls
                # scraping solo con beautifulsoup
                print("Pendiente")
            elif id_url == 3: # remax central
                url3 = requests.get(url, headers=headers, timeout=20)
                if url3.status_code != 200:
                    print(f"Fallo en la extracción de Remax Central en página {page}: {url3.status_code}")
                    break
                soup3 = BeautifulSoup(url3.content, 'html.parser')
                cards = soup3.select(".property-list-item")
                for c in cards:
                    title_tag = c.select_one('p[data-match-height="property-title"]')
                    title = title_tag.get_text(strip=True) if title_tag else None
                    description = title
                    price_tag = c.select_one('div[data-match-height="property-price"]')
                    price = price_tag.get_text(strip=True) if price_tag else None
                    property_type_id = 1
                    icono_ubicacion = c.find('i', class_='icon-map-marker')
                    location = icono_ubicacion.parent.get_text(strip=True)
                    cursor.execute("SELECT id FROM locations WHERE location LIKE %s", (location,))
                    query_result = cursor.fetchone()
                    if query_result:
                        location_id = query_result[0]
                    else:
                        cursor.execute("INSERT INTO locations (location) VALUES (%s)", (location,))
                        location_id = cursor.lastrowid
                        conn.commit()
                    bedrooms = 2
                    bathrooms = 1
                    area = '25 m²'
                    now = date.today()
                    published_at = now.strftime('%Y-%m-%d')
                    image = c.select_one(".img-responsive")
                    image_url = image["src"] if image and image.get("src") else None
                    padre = c.parent
                    link = padre.find('a')
                    source = link['href']

                    #insercion al arreglo de results
                    results.append({
                        'title' : title,
                        'description' : description,
                        'price' : price,
                        'property_type_id' : property_type_id,
                        'location_id' : location_id,
                        'bedrooms' : bedrooms,
                        'bathrooms' : bathrooms,
                        'area' : area,
                        'published_at' : published_at,
                        'image_url' : image_url,
                        'source' : source
                    })




    #arreglo final
    len(results)


except Exception as e:
    print(f"\n¡FALLO CRÍTICO DE EJECUCIÓN!: {e}", file=sys.stderr)

finally:
    if driver:
        driver.quit()
        print("\nProceso de Selenium finalizado y navegador Headless cerrado.")



df = pd.DataFrame(results)

# Limpieza de datos
# Limpiar precio: quitar '$', ',' y convertir a float
def clean_price(price):
    DEFAULT_VALUE = 1000.0

    if price:
        if isinstance(price, str):
            clean_text = price.replace('$', '').replace(',', '').strip()

            try:
                return float(clean_text)
            except ValueError:
                return DEFAULT_VALUE

        return float(price)

    return DEFAULT_VALUE


if not df.empty:
    df['price'] = df['price'].apply(clean_price)
    df = df.where(pd.notnull(df), None)
    df = df.drop_duplicates(subset=['title', 'location_id'])

    print(f"Procesando {len(df)} propiedades para insertar...")

    for index, row in df.iterrows():
        try:
            property_id = None
            # Verificar si ya existe la propiedad
            check_query = "SELECT id FROM properties WHERE title = %s AND location_id = %s"
            cursor.execute(check_query, (row['title'], row['location_id']))
            result = cursor.fetchone()

            if result:
                property_id = result[0]
                print(f"Propiedad '{row['title']}' ya existe (ID: {property_id}).")
            else:
                insert_query = """
                INSERT INTO properties (title, description, price, property_type_id, location_id, bedrooms, bathrooms, area, published_at, image_url, source)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                """
                values = (
                    row['title'],
                    row['description'],
                    row['price'],
                    row['property_type_id'],
                    row['location_id'],
                    row['bedrooms'],
                    row['bathrooms'],
                    row['area'],
                    row['published_at'],
                    row['image_url'],
                    row['source']
                )
                cursor.execute(insert_query, values)
                conn.commit()
                property_id = cursor.lastrowid
                print(f"Propiedad '{row['title']}' insertada correctamente (ID: {property_id}).")

            # Insertar registro en la tabla price history
            if property_id:
                check_price_history_query = "SELECT id FROM price_history WHERE property_id = %s AND date = %s AND price = %s"
                cursor.execute(check_price_history_query, (property_id, row['published_at'], row['price']))

                if cursor.fetchone():
                    print(f"Registro de precio para '{row['title']}' ya existe. Saltando.")
                else:
                    insert_price_history_query = """
                    INSERT INTO price_history (property_id, date, price)
                    VALUES (%s, %s, %s)
                    """
                    values_history = (
                        property_id,
                        row['published_at'],
                        row['price']
                    )
                    cursor.execute(insert_price_history_query, values_history)
                    conn.commit()
                    print(f"Registro de precio para '{row['title']}' insertado correctamente.")

        except Exception as e:
            print(f"Error al procesar propiedad '{row['title']}': {e}")

    print("Proceso de inserción finalizado.")
else:
    print("No hay resultados para procesar.")


# In[22]:


#se sacara la mediana por locacion y comparará el precio de la propiedad con la mediana, y se usara modelo de clasificacion
#para saber si la propiedad es cara o barata

#obtener todas las ubicaciones

ubicaciones = "Select * from locations"
df_ubicaciones = pd.read_sql(ubicaciones, conn)

#recorrer todas las ubicaciones

for index, row in df_ubicaciones.iterrows():
    location_id = row['id']

    properties = "Select id, location_id, price from properties where location_id = " + str(location_id)
    df = pd.read_sql(properties, conn)

    if not df.empty and len(df) >= 2:
        df['median_price'] = df.groupby('location_id')['price'].transform('median')
        df['target_class'] = np.where(df['price'] < df['median_price'], 0, 1)

        X = df[['location_id', 'price']]

        y = df['target_class']

        print("Entrenando clasificador RandomForest...")
        clf = RandomForestClassifier(n_estimators=100, random_state=42)
        clf.fit(X, y)


        predictions = clf.predict(X)

        df['classification_text'] = np.where(predictions == 0, 'BARATA', 'CARA')

        cursor = conn.cursor()
        today = date.today()
        count = 0

        for idx, row in df.iterrows():
            try:
                p_id = int(row['id'])
                l_id = int(row['location_id'])
                med_val = float(row['median_price'])
                cls_txt = str(row['classification_text'])

                # Query de inserción / actualización
                sql = """
                    INSERT INTO price_predictions 
                    (property_id, location_id, predicted_price, model_used, prediction_date)
                    VALUES (%s, %s, %s, %s, %s)
                    ON DUPLICATE KEY UPDATE
                    predicted_price = VALUES(predicted_price),
                    model_used = VALUES(model_used)
                """

                cursor.execute(sql, (p_id, l_id, med_val, cls_txt, today))
                count += 1

            except Exception as e:
                print(f"Error guardando propiedad ID {p_id}: {e}")

        conn.commit()
        print(f"Se guardaron {count} clasificaciones.")

    else:
        print("No hay suficientes datos para realizar la clasificación.")






