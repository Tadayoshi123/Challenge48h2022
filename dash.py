import seaborn as sns
import numpy as np
import pandas as pd
import streamlit as st
import plotly.express as px
import plotly.graph_objects as go
import matplotlib.pyplot as plt
from plotly.offline import init_notebook_mode
init_notebook_mode(connected=True)
import datetime

url =  'https://raw.githubusercontent.com/walidelbou/csv_48h/main/buyers.csv'
df = pd.read_csv(url , delimiter=',')

st.title('Dashboard Utilisateurs :')

st.dataframe(data=df, width=None, height=None)
df = df.rename(columns={'Purchased Bike': 'Client'})

st.header('REPARTITION CLIENT/NON-CLIENT : ')
#data count
print("-------------------------------")
st.text(df["Client"].value_counts())
print("-------------------------------")

#plot data
fig, ax=plt.subplots(figsize=(9, 11))
ax=sns.countplot(x="Client", data=df, hue='Gender', hue_order=['Male', 'Female'])

#Setting labels and font size
ax.set(xlabel='Client', ylabel='Count of No/Yes',title="Numero de clients")
ax.xaxis.get_label().set_fontsize(10)
ax.yaxis.get_label().set_fontsize(10)

st.plotly_chart(fig, use_container_width=True)

st.header('Clients par region: ')
fig, ax=plt.subplots(figsize=(9, 6))
ax=sns.countplot(x="Client", data=df, hue='Region')

#Setting labels and font size
ax.set(xlabel='Client', ylabel='Count of No/Yes',title="")
ax.xaxis.get_label().set_fontsize(14)
ax.yaxis.get_label().set_fontsize(14)

st.plotly_chart(fig, use_container_width=True)

st.header('Clients  en dependant de leur niveau educatif :')
st.text('Rouge: ayant education , Vert : sans education')
fig, ax=plt.subplots(figsize=(11, 6))
sns.set_theme(style='white', palette=None)
sns.histplot(x="Education", data=df, hue="Client", multiple="dodge", shrink=0.6, palette=sns.blend_palette(['red', 'green'], 2))

st.plotly_chart(fig, use_container_width=True)