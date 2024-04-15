import matplotlib.pyplot as plt
import numpy as np
import random
from sklearn.linear_model import LogisticRegression


# X_first_half = [[3 + i, 7 + i] for i in range(0, 20)]
# X_second_half = [[7 + i, 3 + i] for i in range(0, 20)]
X_full = []

Y_origin_full = [0] * 20 + [1] * 20

# Создаем пустые массивы X и Y
X = []
Y_origin = []

# Берем по 4 элемента из первой половины и второй половины X_full
for _ in range(20):
    x1 = random.uniform(0, 7)
    x2 = random.uniform(5, 10)
    X_full.append([x1, x2])

# Для второй половины
for _ in range(20):
    x1 = random.uniform(7, 10)
    x2 = random.uniform(3, 7)
    X_full.append([x1, x2])



# Y_origin = [0, 0, 0, 0, 1, 1, 1, 1] #два класса
W = [0, 0.5, 0.5]


X.extend(X_full[:4])
Y_origin.extend([0] * 4)  # Помечаем их как класс 0

# Берем следующие 4 элемента из X_full
X.extend(X_full[20:24])
Y_origin.extend([1] * 4)  # Помечаем их как класс 1



X_axis = [point[0] for point in X_full]
Y_axis = [point[1] for point in X_full]




X_axis_first = [point[0] for point in X_full[:20]]
Y_axis_first = [point[1] for point in X_full[:20]]

X_axis_second = [point[0] for point in X_full[20:]]
Y_axis_second = [point[1] for point in X_full[20:]]

# Рисуем точки первой половины в красном цвете
plt.scatter(X_axis_first, Y_axis_first, color='salmon')

# Рисуем точки второй половины в синем цвете
plt.scatter(X_axis_second, Y_axis_second, color='cyan')

X_axis_X = [point[0] for point in X]
Y_axis_X = [point[1] for point in X]

# Рисуем точки из списка X, закрашивая первые 4 в цвет salmon
# и следующие 4 в цвет cyan
plt.scatter(X_axis_X[:4], Y_axis_X[:4], color='red', label='First 4 points')
plt.scatter(X_axis_X[4:8], Y_axis_X[4:8], color='blue', label='Next 4 points')


x_values = np.array(range(10))  # значения оси X для построения прямой
w0, w1, w2 = W[0], W[1], W[2]    # значения весов w0, w1, w2

# Вычисляем значения Y для каждого X на прямой
y_values = w0 + w1 * x_values + w2 * x_values

# Рисуем прямую
plt.plot(x_values, y_values, color='red')



# Добавляем метки на оси
plt.xlabel('X')
plt.ylabel('Y')



# Обучение модели логистической регрессии
model = LogisticRegression()
model.fit(X_full, Y_origin_full)

# Получение коэффициентов решающей прямой
w0_logreg = model.intercept_[0]
w1_logreg, w2_logreg = model.coef_[0]

# Вычисление значений Y для решающей прямой логистической регрессии
y_values_logreg = -(w0_logreg + w1_logreg * x_values) / w2_logreg

# Рисование решающей прямой логистической регрессии
plt.plot(x_values, y_values_logreg, color='green', linestyle='--', label='Logistic Regression Decision Boundary')

# Добавление легенды
plt.legend()

# Показать график
plt.show()


# Показываем график
plt.show()
