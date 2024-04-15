import numpy as np
from keras.models import Sequential
from keras.layers import Dense
from keras.utils import plot_model
import matplotlib.pyplot as plt

import os
os.environ["PATH"] += os.pathsep + 'D:/Downloads/Graphviz-10.0.1-win64/bin'

# Определение входных и выходных данных для XOR
inputs = np.array([[0, 0], [0, 1], [1, 0], [1, 1]])
outputs = np.array([[0], [1], [1], [0]])

# Создание модели
model = Sequential()
model.add(Dense(16, input_dim=2, activation='relu', name='hidden')) # Изменено на 16 нейронов и добавлено имя 'hidden'
model.add(Dense(1, activation='sigmoid')) # Изменено на активацию 'sigmoid'

# Компиляция модели
model.compile(loss='binary_crossentropy', optimizer='adam', metrics=['accuracy'])

# Обучение модели
history = model.fit(inputs, outputs, epochs=5000, verbose=0)

# Вывод входных данных
print("Входные данные:")
print(inputs)

# Получение предсказаний модели
predictions = model.predict(inputs, verbose=0)

# Вывод результатов работы модели
print("Результаты работы модели:")
print(predictions)

# Оценка модели
print(model.evaluate(inputs, outputs))

# Визуализация модели
plot_model(model, to_file='model_plot.png', show_shapes=True, show_layer_names=True)

# Визуализация точности и потерь
plt.figure(figsize=(12, 4))

# Точность
plt.subplot(1, 2, 1)
plt.plot(history.history['accuracy'], label='Точность')
plt.title('Точность')
plt.xlabel('Эпохи')
plt.ylabel('Точность')
plt.legend()

# Потери
plt.subplot(1, 2, 2)
plt.plot(history.history['loss'], label='Потери')
plt.title('Потери')
plt.xlabel('Эпохи')
plt.ylabel('Потери')
plt.legend()

plt.tight_layout()
plt.show()
