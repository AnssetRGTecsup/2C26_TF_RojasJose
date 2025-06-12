using TMPro;
using UnityEngine;
using UnityEngine.UI;

public class Timer : MonoBehaviour
{
    [SerializeField] private TMP_Text cronometroText;
    [SerializeField] private Button botonIniciar;
    [SerializeField] private Button botonDetener;
    [SerializeField] private float tiempoTranscurrido = 0f;
    [SerializeField] private float speedTime = 1f;

    private bool cronometroActivo = false;

    void Start()
    {
        ActualizarTextoCronometro();
    }

    void Update()
    {
        if (cronometroActivo)
        {
            tiempoTranscurrido += Time.deltaTime * speedTime;
            ActualizarTextoCronometro();
        }
    }

    void ActualizarTextoCronometro()
    {
        int minutos = Mathf.FloorToInt(tiempoTranscurrido / 60F);
        int segundos = Mathf.FloorToInt(tiempoTranscurrido % 60F);
        int milisegundos = Mathf.FloorToInt((tiempoTranscurrido * 1000F) % 1000F);

        cronometroText.text = string.Format("{0:00}:{1:00}:{2:000}", minutos, segundos, milisegundos);
    }

    public void IniciarCronometro()
    {
        cronometroActivo = true;
    }

    public void DetenerCronometro()
    {
        cronometroActivo = false;
    }

    public void ReiniciarCronometro()
    {
        tiempoTranscurrido = 0f;
        cronometroActivo = false;
        ActualizarTextoCronometro();
    }

    public void SpeedTimerUp()
    {
        speedTime *= 2f;
    }

    public void SpeedTimerDown()
    {
        speedTime /= 2f;
    }
}
