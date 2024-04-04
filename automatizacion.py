# Importar las clases necesarias de Selenium
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
import time 
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.firefox.options import Options

from selenium.webdriver.common.action_chains import ActionChains

# Ruta de la carpeta de descargas
download_folder = "C:\laragon\www\comfica_back\public\EXPORTACION"

# Configurar opciones de Firefox
options = Options()
options.set_preference("browser.download.folderList", 2)  # Usar una carpeta específica
options.set_preference("browser.download.dir", download_folder)  # Establecer la carpeta de descargas
options.set_preference("browser.download.useDownloadDir", True)  # Usar siempre la carpeta de descargas sin preguntar
options.set_preference("browser.helperApps.neverAsk.saveToDisk", "application/pdf")  # Tipo MIME para descarga automática, ajustar según necesidad
options.set_preference("pdfjs.disabled", True)  # Deshabilitar el visor PDF de Firefox

# Crear el objeto de controlador del navegador Firefox con las opciones configuradas
driver = webdriver.Firefox(options=options)
# Crear un objeto de controlador del navegador Firefox
# driver = webdriver.Firefox()
# Navegar a la página web "https://telefonica-pe.etadirect.com/"
driver.get("https://telefonica-pe.etadirect.com/")

# Esperar hasta que el elemento con NAME "username" esté presente en el DOM (tiempo máximo de espera: 30 segundos)
time.sleep(3)
wait = WebDriverWait(driver, 10)
usuario = wait.until(EC.presence_of_element_located((By.NAME, "username")))

# Agregar el usuario "miusuario" al campo de usuario
usuario.send_keys("CF0231")

# Encontrar el elemento del campo de contraseña por su NAME (ajustar según la estructura del formulario)
password = driver.find_element(By.NAME, "password")

# Agregar la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)


# Esperar hasta que el  NAME "password" esté presente en el DOM
wait.until(EC.presence_of_element_located((By.NAME, "password")))

# Esperar hasta que el checkbox con NAME "delsession" esté presente en el DOM
checkbox = wait.until(EC.presence_of_element_located((By.NAME, "delsession")))

# Seleccionar el checkbox
checkbox.click()

# Encontrar el elemento del campo de contraseña nuevamente (puede ser necesario dependiendo de la lógica de la página)
password = driver.find_element(By.NAME, "password")

# Agregar nuevamente la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)

time.sleep(5)

# Esperar hasta 10 segundos a que aparezca el botón
boton = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.CLASS_NAME, "toolbar-date-picker-button"))
)

# Hacer clic en el botón
boton.click()

# Realizar la acción de presionar la tecla "Escape"
action_chains = ActionChains(driver)
action_chains.send_keys(Keys.ESCAPE).perform()
action_chains.send_keys(Keys.ESCAPE).perform()

# Esperar un segundo
time.sleep(1)

action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()


action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.SPACE).perform()
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.ENTER).perform()

# carpeta de trabajo 


# Esperar a que el archivo esté completamente descargado
# Esto puede ser tan simple como esperar un tiempo fijo si sabes cuánto tardará aproximadamente
time.sleep(10)  # Espera 10 segundos, ajusta este tiempo según sea necesario

# O mejor aún, espera hasta que el archivo aparezca y el tamaño de archivo deje de cambiar
import os

filename = max([download_folder + "\\" + f for f in os.listdir(download_folder)], key=os.path.getctime)
filesize = -1

while True:
    new_filesize = os.path.getsize(filename)
    if filesize == new_filesize:
        break
    else:
        filesize = new_filesize
        time.sleep(1)

# Una vez que el archivo está descargado, navegar a la página de importación
driver.get('http://comfica_back.test:8084/import')

# Esperar hasta que el input para subir archivos esté presente
file_input = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.NAME, "file"))
)

# Enviar el archivo
file_input.send_keys(filename)

# Esperar hasta que el botón de enviar esté presente
submit_button = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.ID, "submit-button"))
)



# Hacer clic en el botón de enviar
submit_button.click()

time.sleep(60)

# Ahora deberías manejar la espera y verificación de que la importación se haya completado correctamente
# Esto puede involucrar esperar mensajes específicos en la página o verificar que se redirija a una nueva URL

#---------------------------------------------------------------------------------------------------------------------------------------------------
#---------------------------------------------AHORA SE VUELVE A CORRER LO MISMO, PERO CON OTRA FECHA 2------------------------------------------------
download_folder = "C:\laragon\www\comfica_back\public\EXPORTACION"

# Configurar opciones de Firefox
options = Options()
options.set_preference("browser.download.folderList", 2)  # Usar una carpeta específica
options.set_preference("browser.download.dir", download_folder)  # Establecer la carpeta de descargas
options.set_preference("browser.download.useDownloadDir", True)  # Usar siempre la carpeta de descargas sin preguntar
options.set_preference("browser.helperApps.neverAsk.saveToDisk", "application/pdf")  # Tipo MIME para descarga automática, ajustar según necesidad
options.set_preference("pdfjs.disabled", True)  # Deshabilitar el visor PDF de Firefox

# Crear el objeto de controlador del navegador Firefox con las opciones configuradas
driver = webdriver.Firefox(options=options)
# Crear un objeto de controlador del navegador Firefox
# driver = webdriver.Firefox()
# Navegar a la página web "https://telefonica-pe.etadirect.com/"
driver.get("https://telefonica-pe.etadirect.com/")

# Esperar hasta que el elemento con NAME "username" esté presente en el DOM (tiempo máximo de espera: 30 segundos)
time.sleep(3)
wait = WebDriverWait(driver, 10)
usuario = wait.until(EC.presence_of_element_located((By.NAME, "username")))

# Agregar el usuario "miusuario" al campo de usuario
usuario.send_keys("CF0231")

# Encontrar el elemento del campo de contraseña por su NAME (ajustar según la estructura del formulario)
password = driver.find_element(By.NAME, "password")

# Agregar la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)


# Esperar hasta que el  NAME "password" esté presente en el DOM
wait.until(EC.presence_of_element_located((By.NAME, "password")))

# Esperar hasta que el checkbox con NAME "delsession" esté presente en el DOM
checkbox = wait.until(EC.presence_of_element_located((By.NAME, "delsession")))

# Seleccionar el checkbox
checkbox.click()

# Encontrar el elemento del campo de contraseña nuevamente (puede ser necesario dependiendo de la lógica de la página)
password = driver.find_element(By.NAME, "password")

# Agregar nuevamente la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)

time.sleep(5)

# Esperar hasta 10 segundos a que aparezca el botón
boton = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.CLASS_NAME, "toolbar-date-picker-button"))
)

# Hacer clic en el botón
boton.click()

# Realizar la acción de presionar la tecla "Escape"
action_chains = ActionChains(driver)
action_chains.send_keys(Keys.ESCAPE).perform()
action_chains.send_keys(Keys.ESCAPE).perform()

# Esperar un segundo
time.sleep(1)

action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()


action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.SPACE).perform()
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.ENTER).perform()

# carpeta de trabajo 


# Esperar a que el archivo esté completamente descargado
# Esto puede ser tan simple como esperar un tiempo fijo si sabes cuánto tardará aproximadamente
time.sleep(10)  # Espera 10 segundos, ajusta este tiempo según sea necesario

# O mejor aún, espera hasta que el archivo aparezca y el tamaño de archivo deje de cambiar
import os

filename = max([download_folder + "\\" + f for f in os.listdir(download_folder)], key=os.path.getctime)
filesize = -1

while True:
    new_filesize = os.path.getsize(filename)
    if filesize == new_filesize:
        break
    else:
        filesize = new_filesize
        time.sleep(1)

# Una vez que el archivo está descargado, navegar a la página de importación
driver.get('http://comfica_back.test:8084/import')

# Esperar hasta que el input para subir archivos esté presente
file_input = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.NAME, "file"))
)

# Enviar el archivo
file_input.send_keys(filename)

# Esperar hasta que el botón de enviar esté presente
submit_button = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.ID, "submit-button"))
)



# Hacer clic en el botón de enviar
submit_button.click()

time.sleep(60)

#---------------------------------------------------------------------------------------------------------------------------------------------------
#---------------------------------------------AHORA SE VUELVE A CORRER LO MISMO, PERO CON OTRA FECHA 3------------------------------------------------
download_folder = "C:\laragon\www\comfica_back\public\EXPORTACION"

# Configurar opciones de Firefox
options = Options()
options.set_preference("browser.download.folderList", 2)  # Usar una carpeta específica
options.set_preference("browser.download.dir", download_folder)  # Establecer la carpeta de descargas
options.set_preference("browser.download.useDownloadDir", True)  # Usar siempre la carpeta de descargas sin preguntar
options.set_preference("browser.helperApps.neverAsk.saveToDisk", "application/pdf")  # Tipo MIME para descarga automática, ajustar según necesidad
options.set_preference("pdfjs.disabled", True)  # Deshabilitar el visor PDF de Firefox

# Crear el objeto de controlador del navegador Firefox con las opciones configuradas
driver = webdriver.Firefox(options=options)
# Crear un objeto de controlador del navegador Firefox
# driver = webdriver.Firefox()
# Navegar a la página web "https://telefonica-pe.etadirect.com/"
driver.get("https://telefonica-pe.etadirect.com/")

# Esperar hasta que el elemento con NAME "username" esté presente en el DOM (tiempo máximo de espera: 30 segundos)
time.sleep(3)
wait = WebDriverWait(driver, 10)
usuario = wait.until(EC.presence_of_element_located((By.NAME, "username")))

# Agregar el usuario "miusuario" al campo de usuario
usuario.send_keys("CF0231")

# Encontrar el elemento del campo de contraseña por su NAME (ajustar según la estructura del formulario)
password = driver.find_element(By.NAME, "password")

# Agregar la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)


# Esperar hasta que el  NAME "password" esté presente en el DOM
wait.until(EC.presence_of_element_located((By.NAME, "password")))

# Esperar hasta que el checkbox con NAME "delsession" esté presente en el DOM
checkbox = wait.until(EC.presence_of_element_located((By.NAME, "delsession")))

# Seleccionar el checkbox
checkbox.click()

# Encontrar el elemento del campo de contraseña nuevamente (puede ser necesario dependiendo de la lógica de la página)
password = driver.find_element(By.NAME, "password")

# Agregar nuevamente la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)

time.sleep(5)

# Esperar hasta 10 segundos a que aparezca el botón
boton = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.CLASS_NAME, "toolbar-date-picker-button"))
)

# Hacer clic en el botón
boton.click()

# Realizar la acción de presionar la tecla "Escape"
action_chains = ActionChains(driver)
action_chains.send_keys(Keys.ESCAPE).perform()
action_chains.send_keys(Keys.ESCAPE).perform()

# Esperar un segundo
time.sleep(1)

action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()


action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.SPACE).perform()
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.ENTER).perform()

# carpeta de trabajo 


# Esperar a que el archivo esté completamente descargado
# Esto puede ser tan simple como esperar un tiempo fijo si sabes cuánto tardará aproximadamente
time.sleep(10)  # Espera 10 segundos, ajusta este tiempo según sea necesario

# O mejor aún, espera hasta que el archivo aparezca y el tamaño de archivo deje de cambiar
import os

filename = max([download_folder + "\\" + f for f in os.listdir(download_folder)], key=os.path.getctime)
filesize = -1

while True:
    new_filesize = os.path.getsize(filename)
    if filesize == new_filesize:
        break
    else:
        filesize = new_filesize
        time.sleep(1)

# Una vez que el archivo está descargado, navegar a la página de importación
driver.get('http://comfica_back.test:8084/import')

# Esperar hasta que el input para subir archivos esté presente
file_input = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.NAME, "file"))
)

# Enviar el archivo
file_input.send_keys(filename)

# Esperar hasta que el botón de enviar esté presente
submit_button = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.ID, "submit-button"))
)



# Hacer clic en el botón de enviar
submit_button.click()
time.sleep(60)


#---------------------------------------------------------------------------------------------------------------------------------------------------
#---------------------------------------------AHORA SE VUELVE A CORRER LO MISMO, PERO CON OTRA FECHA 4------------------------------------------------
download_folder = "C:\laragon\www\comfica_back\public\EXPORTACION"

# Configurar opciones de Firefox
options = Options()
options.set_preference("browser.download.folderList", 2)  # Usar una carpeta específica
options.set_preference("browser.download.dir", download_folder)  # Establecer la carpeta de descargas
options.set_preference("browser.download.useDownloadDir", True)  # Usar siempre la carpeta de descargas sin preguntar
options.set_preference("browser.helperApps.neverAsk.saveToDisk", "application/pdf")  # Tipo MIME para descarga automática, ajustar según necesidad
options.set_preference("pdfjs.disabled", True)  # Deshabilitar el visor PDF de Firefox

# Crear el objeto de controlador del navegador Firefox con las opciones configuradas
driver = webdriver.Firefox(options=options)
# Crear un objeto de controlador del navegador Firefox
# driver = webdriver.Firefox()
# Navegar a la página web "https://telefonica-pe.etadirect.com/"
driver.get("https://telefonica-pe.etadirect.com/")

# Esperar hasta que el elemento con NAME "username" esté presente en el DOM (tiempo máximo de espera: 30 segundos)
time.sleep(3)
wait = WebDriverWait(driver, 10)
usuario = wait.until(EC.presence_of_element_located((By.NAME, "username")))

# Agregar el usuario "miusuario" al campo de usuario
usuario.send_keys("CF0231")

# Encontrar el elemento del campo de contraseña por su NAME (ajustar según la estructura del formulario)
password = driver.find_element(By.NAME, "password")

# Agregar la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)


# Esperar hasta que el  NAME "password" esté presente en el DOM
wait.until(EC.presence_of_element_located((By.NAME, "password")))

# Esperar hasta que el checkbox con NAME "delsession" esté presente en el DOM
checkbox = wait.until(EC.presence_of_element_located((By.NAME, "delsession")))

# Seleccionar el checkbox
checkbox.click()

# Encontrar el elemento del campo de contraseña nuevamente (puede ser necesario dependiendo de la lógica de la página)
password = driver.find_element(By.NAME, "password")

# Agregar nuevamente la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)

time.sleep(5)

# Esperar hasta 10 segundos a que aparezca el botón
boton = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.CLASS_NAME, "toolbar-date-picker-button"))
)

# Hacer clic en el botón
boton.click()

# Realizar la acción de presionar la tecla "Escape"
action_chains = ActionChains(driver)
action_chains.send_keys(Keys.ESCAPE).perform()
action_chains.send_keys(Keys.ESCAPE).perform()

# Esperar un segundo
time.sleep(1)

action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()


action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.SPACE).perform()
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.ENTER).perform()

# carpeta de trabajo 


# Esperar a que el archivo esté completamente descargado
# Esto puede ser tan simple como esperar un tiempo fijo si sabes cuánto tardará aproximadamente
time.sleep(10)  # Espera 10 segundos, ajusta este tiempo según sea necesario

# O mejor aún, espera hasta que el archivo aparezca y el tamaño de archivo deje de cambiar
import os

filename = max([download_folder + "\\" + f for f in os.listdir(download_folder)], key=os.path.getctime)
filesize = -1

while True:
    new_filesize = os.path.getsize(filename)
    if filesize == new_filesize:
        break
    else:
        filesize = new_filesize
        time.sleep(1)

# Una vez que el archivo está descargado, navegar a la página de importación
driver.get('http://comfica_back.test:8084/import')

# Esperar hasta que el input para subir archivos esté presente
file_input = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.NAME, "file"))
)

# Enviar el archivo
file_input.send_keys(filename)

# Esperar hasta que el botón de enviar esté presente
submit_button = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.ID, "submit-button"))
)



# Hacer clic en el botón de enviar
submit_button.click()
time.sleep(60)


#---------------------------------------------------------------------------------------------------------------------------------------------------
#---------------------------------------------AHORA SE VUELVE A CORRER LO MISMO, PERO CON OTRA FECHA 5------------------------------------------------
download_folder = "C:\laragon\www\comfica_back\public\EXPORTACION"

# Configurar opciones de Firefox
options = Options()
options.set_preference("browser.download.folderList", 2)  # Usar una carpeta específica
options.set_preference("browser.download.dir", download_folder)  # Establecer la carpeta de descargas
options.set_preference("browser.download.useDownloadDir", True)  # Usar siempre la carpeta de descargas sin preguntar
options.set_preference("browser.helperApps.neverAsk.saveToDisk", "application/pdf")  # Tipo MIME para descarga automática, ajustar según necesidad
options.set_preference("pdfjs.disabled", True)  # Deshabilitar el visor PDF de Firefox

# Crear el objeto de controlador del navegador Firefox con las opciones configuradas
driver = webdriver.Firefox(options=options)
# Crear un objeto de controlador del navegador Firefox
# driver = webdriver.Firefox()
# Navegar a la página web "https://telefonica-pe.etadirect.com/"
driver.get("https://telefonica-pe.etadirect.com/")

# Esperar hasta que el elemento con NAME "username" esté presente en el DOM (tiempo máximo de espera: 30 segundos)
time.sleep(3)
wait = WebDriverWait(driver, 10)
usuario = wait.until(EC.presence_of_element_located((By.NAME, "username")))

# Agregar el usuario "miusuario" al campo de usuario
usuario.send_keys("CF0231")

# Encontrar el elemento del campo de contraseña por su NAME (ajustar según la estructura del formulario)
password = driver.find_element(By.NAME, "password")

# Agregar la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)


# Esperar hasta que el  NAME "password" esté presente en el DOM
wait.until(EC.presence_of_element_located((By.NAME, "password")))

# Esperar hasta que el checkbox con NAME "delsession" esté presente en el DOM
checkbox = wait.until(EC.presence_of_element_located((By.NAME, "delsession")))

# Seleccionar el checkbox
checkbox.click()

# Encontrar el elemento del campo de contraseña nuevamente (puede ser necesario dependiendo de la lógica de la página)
password = driver.find_element(By.NAME, "password")

# Agregar nuevamente la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)

time.sleep(5)

# Esperar hasta 10 segundos a que aparezca el botón
boton = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.CLASS_NAME, "toolbar-date-picker-button"))
)

# Hacer clic en el botón
boton.click()

# Realizar la acción de presionar la tecla "Escape"
action_chains = ActionChains(driver)
action_chains.send_keys(Keys.ESCAPE).perform()
action_chains.send_keys(Keys.ESCAPE).perform()

# Esperar un segundo
time.sleep(1)

action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()


action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.SPACE).perform()
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.ENTER).perform()

# carpeta de trabajo 


# Esperar a que el archivo esté completamente descargado
# Esto puede ser tan simple como esperar un tiempo fijo si sabes cuánto tardará aproximadamente
time.sleep(10)  # Espera 10 segundos, ajusta este tiempo según sea necesario

# O mejor aún, espera hasta que el archivo aparezca y el tamaño de archivo deje de cambiar
import os

filename = max([download_folder + "\\" + f for f in os.listdir(download_folder)], key=os.path.getctime)
filesize = -1

while True:
    new_filesize = os.path.getsize(filename)
    if filesize == new_filesize:
        break
    else:
        filesize = new_filesize
        time.sleep(1)

# Una vez que el archivo está descargado, navegar a la página de importación
driver.get('http://comfica_back.test:8084/import')

# Esperar hasta que el input para subir archivos esté presente
file_input = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.NAME, "file"))
)

# Enviar el archivo
file_input.send_keys(filename)

# Esperar hasta que el botón de enviar esté presente
submit_button = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.ID, "submit-button"))
)



# Hacer clic en el botón de enviar
submit_button.click()
time.sleep(60)


#---------------------------------------------------------------------------------------------------------------------------------------------------
#---------------------------------------------AHORA SE VUELVE A CORRER LO MISMO, PERO CON OTRA FECHA 6------------------------------------------------
download_folder = "C:\laragon\www\comfica_back\public\EXPORTACION"

# Configurar opciones de Firefox
options = Options()
options.set_preference("browser.download.folderList", 2)  # Usar una carpeta específica
options.set_preference("browser.download.dir", download_folder)  # Establecer la carpeta de descargas
options.set_preference("browser.download.useDownloadDir", True)  # Usar siempre la carpeta de descargas sin preguntar
options.set_preference("browser.helperApps.neverAsk.saveToDisk", "application/pdf")  # Tipo MIME para descarga automática, ajustar según necesidad
options.set_preference("pdfjs.disabled", True)  # Deshabilitar el visor PDF de Firefox

# Crear el objeto de controlador del navegador Firefox con las opciones configuradas
driver = webdriver.Firefox(options=options)
# Crear un objeto de controlador del navegador Firefox
# driver = webdriver.Firefox()
# Navegar a la página web "https://telefonica-pe.etadirect.com/"
driver.get("https://telefonica-pe.etadirect.com/")

# Esperar hasta que el elemento con NAME "username" esté presente en el DOM (tiempo máximo de espera: 30 segundos)
time.sleep(3)
wait = WebDriverWait(driver, 10)
usuario = wait.until(EC.presence_of_element_located((By.NAME, "username")))

# Agregar el usuario "miusuario" al campo de usuario
usuario.send_keys("CF0231")

# Encontrar el elemento del campo de contraseña por su NAME (ajustar según la estructura del formulario)
password = driver.find_element(By.NAME, "password")

# Agregar la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)


# Esperar hasta que el  NAME "password" esté presente en el DOM
wait.until(EC.presence_of_element_located((By.NAME, "password")))

# Esperar hasta que el checkbox con NAME "delsession" esté presente en el DOM
checkbox = wait.until(EC.presence_of_element_located((By.NAME, "delsession")))

# Seleccionar el checkbox
checkbox.click()

# Encontrar el elemento del campo de contraseña nuevamente (puede ser necesario dependiendo de la lógica de la página)
password = driver.find_element(By.NAME, "password")

# Agregar nuevamente la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)

time.sleep(5)

# Esperar hasta 10 segundos a que aparezca el botón
boton = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.CLASS_NAME, "toolbar-date-picker-button"))
)

# Hacer clic en el botón
boton.click()

# Realizar la acción de presionar la tecla "Escape"
action_chains = ActionChains(driver)
action_chains.send_keys(Keys.ESCAPE).perform()
action_chains.send_keys(Keys.ESCAPE).perform()

# Esperar un segundo
time.sleep(1)

action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()


action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.SPACE).perform()
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.ENTER).perform()

# carpeta de trabajo 


# Esperar a que el archivo esté completamente descargado
# Esto puede ser tan simple como esperar un tiempo fijo si sabes cuánto tardará aproximadamente
time.sleep(10)  # Espera 10 segundos, ajusta este tiempo según sea necesario

# O mejor aún, espera hasta que el archivo aparezca y el tamaño de archivo deje de cambiar
import os

filename = max([download_folder + "\\" + f for f in os.listdir(download_folder)], key=os.path.getctime)
filesize = -1

while True:
    new_filesize = os.path.getsize(filename)
    if filesize == new_filesize:
        break
    else:
        filesize = new_filesize
        time.sleep(1)

# Una vez que el archivo está descargado, navegar a la página de importación
driver.get('http://comfica_back.test:8084/import')

# Esperar hasta que el input para subir archivos esté presente
file_input = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.NAME, "file"))
)

# Enviar el archivo
file_input.send_keys(filename)

# Esperar hasta que el botón de enviar esté presente
submit_button = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.ID, "submit-button"))
)



# Hacer clic en el botón de enviar
submit_button.click()
time.sleep(60)


#---------------------------------------------------------------------------------------------------------------------------------------------------
#---------------------------------------------AHORA SE VUELVE A CORRER LO MISMO, PERO CON OTRA FECHA 7------------------------------------------------
download_folder = "C:\laragon\www\comfica_back\public\EXPORTACION"

# Configurar opciones de Firefox
options = Options()
options.set_preference("browser.download.folderList", 2)  # Usar una carpeta específica
options.set_preference("browser.download.dir", download_folder)  # Establecer la carpeta de descargas
options.set_preference("browser.download.useDownloadDir", True)  # Usar siempre la carpeta de descargas sin preguntar
options.set_preference("browser.helperApps.neverAsk.saveToDisk", "application/pdf")  # Tipo MIME para descarga automática, ajustar según necesidad
options.set_preference("pdfjs.disabled", True)  # Deshabilitar el visor PDF de Firefox

# Crear el objeto de controlador del navegador Firefox con las opciones configuradas
driver = webdriver.Firefox(options=options)
# Crear un objeto de controlador del navegador Firefox
# driver = webdriver.Firefox()
# Navegar a la página web "https://telefonica-pe.etadirect.com/"
driver.get("https://telefonica-pe.etadirect.com/")

# Esperar hasta que el elemento con NAME "username" esté presente en el DOM (tiempo máximo de espera: 30 segundos)
time.sleep(3)
wait = WebDriverWait(driver, 10)
usuario = wait.until(EC.presence_of_element_located((By.NAME, "username")))

# Agregar el usuario "miusuario" al campo de usuario
usuario.send_keys("CF0231")

# Encontrar el elemento del campo de contraseña por su NAME (ajustar según la estructura del formulario)
password = driver.find_element(By.NAME, "password")

# Agregar la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)


# Esperar hasta que el  NAME "password" esté presente en el DOM
wait.until(EC.presence_of_element_located((By.NAME, "password")))

# Esperar hasta que el checkbox con NAME "delsession" esté presente en el DOM
checkbox = wait.until(EC.presence_of_element_located((By.NAME, "delsession")))

# Seleccionar el checkbox
checkbox.click()

# Encontrar el elemento del campo de contraseña nuevamente (puede ser necesario dependiendo de la lógica de la página)
password = driver.find_element(By.NAME, "password")

# Agregar nuevamente la contraseña "mipass$" al campo de contraseña
password.send_keys("JD41774023bc$")

# Enviar el formulario presionando la tecla Enter (a través de Selenium Keys)
password.send_keys(Keys.RETURN)

time.sleep(5)

# Esperar hasta 10 segundos a que aparezca el botón
boton = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.CLASS_NAME, "toolbar-date-picker-button"))
)

# Hacer clic en el botón
boton.click()

# Realizar la acción de presionar la tecla "Escape"
action_chains = ActionChains(driver)
action_chains.send_keys(Keys.ESCAPE).perform()
action_chains.send_keys(Keys.ESCAPE).perform()

# Esperar un segundo
time.sleep(1)

action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()


action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.SPACE).perform()
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
time.sleep(1)
action_chains.send_keys(Keys.ENTER).perform()
time.sleep(1)
action_chains.send_keys(Keys.TAB).perform()
action_chains.send_keys(Keys.ENTER).perform()

# carpeta de trabajo 


# Esperar a que el archivo esté completamente descargado
# Esto puede ser tan simple como esperar un tiempo fijo si sabes cuánto tardará aproximadamente
time.sleep(10)  # Espera 10 segundos, ajusta este tiempo según sea necesario

# O mejor aún, espera hasta que el archivo aparezca y el tamaño de archivo deje de cambiar
import os

filename = max([download_folder + "\\" + f for f in os.listdir(download_folder)], key=os.path.getctime)
filesize = -1

while True:
    new_filesize = os.path.getsize(filename)
    if filesize == new_filesize:
        break
    else:
        filesize = new_filesize
        time.sleep(1)

# Una vez que el archivo está descargado, navegar a la página de importación
driver.get('http://comfica_back.test:8084/import')

# Esperar hasta que el input para subir archivos esté presente
file_input = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.NAME, "file"))
)

# Enviar el archivo
file_input.send_keys(filename)

# Esperar hasta que el botón de enviar esté presente
submit_button = WebDriverWait(driver, 20).until(
    EC.presence_of_element_located((By.ID, "submit-button"))
)



# Hacer clic en el botón de enviar
submit_button.click()
