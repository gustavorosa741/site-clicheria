from sqlalchemy import Column, Integer, String, Date, Boolean
from sqlalchemy import create_engine
from sqlalchemy.orm import declarative_base, sessionmaker
from dotenv import load_dotenv
import os



load_dotenv()

usuario = os.getenv("USUARIO")
senha = os.getenv("SENHA")

engine = create_engine(f"mysql+pymysql://{usuario}:{senha}@localhost:3306/clicheria?charset=utf8mb4")

Base = declarative_base()
Session = sessionmaker(bind=engine)
session = Session()

class Chamado(Base):
    __tablename__ = 'tab_clicheria'
    id_cliche = Column(Integer, primary_key=True)
    cliente = Column(String(200), nullable=False)
    produto = Column(String(200), nullable=False)
    codigo = Column(Integer, nullable=False)
    armario = Column(Integer, nullable=False)
    prateleira = Column(String(100), nullable=False)
    cores = Column(Integer,nullable=False)
    cor01 = Column(String(50), nullable=False)
    cor02 = Column(String(50), nullable=False)
    cor03 = Column(String(50), nullable=False)
    cor04 = Column(String(50), nullable=False)
    cor05 = Column(String(50), nullable=False)
    cor06 = Column(String(50), nullable=False)
    cor07 = Column(String(50), nullable=False)
    cor08 = Column(String(50), nullable=False)
    cor09 = Column(String(50), nullable=False)
    cor10 = Column(String(50), nullable=False)
    gravacao01 = Column(Date, nullable=False)
    gravacao02 = Column(Date, nullable=False)
    gravacao03 = Column(Date, nullable=False)
    gravacao04 = Column(Date, nullable=False)
    gravacao05 = Column(Date, nullable=False)
    gravacao06 = Column(Date, nullable=False)
    gravacao07 = Column(Date, nullable=False)
    gravacao08 = Column(Date, nullable=False)
    gravacao09 = Column(Date, nullable=False)
    gravacao10 = Column(Date, nullable=False)
    reserva01 = Column(Boolean, nullable=False)
    reserva02 = Column(Boolean, nullable=False)
    reserva03 = Column(Boolean, nullable=False)
    reserva04 = Column(Boolean, nullable=False)
    reserva05 = Column(Boolean, nullable=False)
    reserva06 = Column(Boolean, nullable=False)
    reserva07 = Column(Boolean, nullable=False)
    reserva08 = Column(Boolean, nullable=False)
    reserva09 = Column(Boolean, nullable=False)
    reserva10 = Column(Boolean, nullable=False)
    observacao = Column(String(200), nullable=False)
    camisa = Column(String(200), nullable=False)





		











def create_tables():
    Base.metadata.create_all(engine)

def main():
    create_tables()
    print("Tabelas criadas com sucesso!")

if __name__ == "__main__":
    main()