
namespace ObserverPattern
{
    public interface Subject
    {
        void registerObserver(Observer o);
        void removeObserver(Observer o);
        void notifyObservers();
    }

    public interface Observer
    {
        void Update(float temp, float humidity, float pressure);
    }

    public interface DisplayElement
    {
        void display();
    }

    class Simulator
    {
        static void Main()
        {

        }
    }
}
