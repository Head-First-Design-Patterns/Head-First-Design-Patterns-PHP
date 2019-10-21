
namespace ObserverPattern
{
    public interface ISubject
    {
        void RegisterObserver(IObserver o);
        void RemoveObserver(IObserver o);
        void NotifyObservers();
    }

    public interface IObserver
    {
        void Update(float temp, float humidity, float pressure);
    }

    public interface IDisplayElement
    {
        void Display();
    }

    internal static class Simulator
    {
        private static void Main()
        {
        }
    }
}
